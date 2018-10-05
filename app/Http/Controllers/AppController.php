<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;
use App\Http\Helpers\EmployeerHelper;
use App\Http\Helpers\RegexHelper;
use App\Models\Employee;
use App\Models\EmployeeImg;
use \DB;
use \Storage;

class AppController extends Controller {

    const MinSalaryValue = 1000;
    const MaxSalaryValue = 1000000000;

    public function home(){

        return view('home');

    }//home

    public function treeview(){

        return view('treeview', ['success' => session('success'), 'error' => session('error')]);

    }//treeview

    public function singleEmployee($EmployeeID){

        $employee = EmployeerHelper::getFullEmployee($EmployeeID);

        if($employee){

            $EmploymentDate = str_replace('Z', '', $employee->EmploymentDate);

            $EmploymentDate = str_replace(' ', 'T', $EmploymentDate);

            $imgPath = $employee->employeeimg ? '/img/employees/'.$employee->employeeimg->ImgName : '/img/user.png';

            return view('single-employee', ['ImgPath' => $imgPath, 'Employee' => $employee, 'EmploymentDate' => $EmploymentDate, 'MinSalaryValue' => self::MinSalaryValue, 'MaxSalaryValue' => self::MaxSalaryValue, 'success' => session('success'), 'error' => session('error')]);

        }//if
        else{

            abort(404);

        }//else

    }//singleEmployee

    public function list(){

        $sort = [
            'EmployeeID',
            'FirstName',
            'LastName',
            'SurName',
            'Salary',
            'Position',
            'EmploymentDate',
        ];

        $limit = [
            10,
            25,
            50,
            100
        ];

        $search = [
            'EmployeeID',
            'FirstName',
            'LastName',
            'SurName',
            'Salary',
        ];

        return view('list', ['sort' => $sort, 'search' => $search,'limit' => $limit]);

    }//list

    public function updateEmployee(Request $request){

        $EmployeeID = $request->get('id');
        $FirstName = $request->get('FirstName');
        $LastName = $request->get('LastName');
        $SurName = $request->get('SurName');
        $ChiefID = $request->get('ChiefID');
        $PositionID = 1;
        $EmploymentDate = $request->get('EmploymentDate');
        $Salary = $request->get('Salary');
        $EmployeeImgID = null;

        $success = null;
        $error = null;

        if($EmployeeID && $FirstName && $LastName && $PositionID && $EmploymentDate && $Salary){

            if(!RegexHelper::IsMatch($FirstName, RegexHelper::EmployeeName())){

                $error = 'Incorrect FirstName';

            }//if
            else if(!RegexHelper::IsMatch($LastName, RegexHelper::EmployeeName())){

                $error = 'Incorrect LastName';

            }//else if
            else if ($SurName && !RegexHelper::IsMatch($SurName, RegexHelper::EmployeeName())){

                $error = 'Incorrect SurName';

            }//else if
            else if ($EmploymentDate && !RegexHelper::IsMatch($EmploymentDate, RegexHelper::EmployeeDate())){

                $error = 'Incorrect Employment Date';

            }//else if
            else if($Salary < self::MinSalaryValue || $Salary > self::MaxSalaryValue){

                $error = 'Incorrect Salary';

            }//else if

            $employee = EmployeerHelper::getFullEmployee($EmployeeID);

            if(!$error && $employee){

                $EmployeeImgID = $employee->EmployeeImgID;

                if($request->hasFile('image')){

                    $file = $request->file('image');

                    if($file->getSize() > 10485760){

                        $error = 'Size image should not be exceed 10 mb';

                    }//if
                    else{

                        $ext = $file->extension();

                        $NewFileName = "${EmployeeID}.${ext}";

                        Storage::disk('public_img_employees')->putFileAs('/', $file, $NewFileName);

                        $files = Storage::disk('public_img_employees')->allFiles();

                        Storage::disk('public')->putFileAs('/', $file, $NewFileName);

                        $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
                        $contentType = mime_content_type(Storage::disk('public_img_employees')->path($NewFileName));

                        if(!in_array($contentType, $allowedMimeTypes)){

                            $error = 'File is not an image';

                        }//if
                        else{

                            foreach ($files as $f) {

                                if(pathinfo($f)['filename'] == $EmployeeID){

                                    Storage::disk('public_img_employees')->delete($f);

                                }//if

                            }//foreach

                            Storage::disk('public_img_employees')->putFileAs('/', $file, $NewFileName);

                            $EmployeeImgID = EmployeerHelper::createOrUpdateImg($EmployeeID, $NewFileName);

                            if(!$EmployeeImgID){

                                Storage::disk('public_img_employees')->delete($NewFileName);
                                $error = 'Create file error';

                            }//if

                        }//else

                        Storage::disk('public')->delete($NewFileName);

                    }//else

                }//if

            }//if

            if(!$error && $ChiefID){

                if($ChiefID == $EmployeeID){

                    $error = 'Employee can not be yourself chief';

                }//if
                else{

                    $chief = Employee::find($ChiefID);

                    if(!$chief){

                        $error = 'Chief not found';

                    }//if
                    else{

                        $positionID = $chief->PositionID;

                        if($positionID == 5){

                            $error = 'Worker can not be Chief';

                        }//if
                        else{

                            $PositionID = $positionID + 1;

                        }//else

                    }//esle

                }//else

            }//if

            if($employee){

                if(!$error){

                    if($employee->PositionID != $PositionID){

                        if(!EmployeerHelper::ChangeChief($EmployeeID)){

                            $error = 'Change chief error';

                        }//if

                    }//if

                }//if

            }//if
            else{

                $error = 'Employee not found';

            }//else

            if(!$error){

                DB::table('employees')->where('EmployeeID', '=', $EmployeeID)->update(['FirstName' => $FirstName, 'LastName' => $LastName, 'SurName' => $SurName, 'ChiefID' => $ChiefID, 'PositionID' => $PositionID, 'EmploymentDate' => $EmploymentDate, 'Salary' => $Salary, 'EmployeeImgID' => $EmployeeImgID]);

                $success = 'Employee updated';

            }//if

        }//if
        else{

            $error = 'Incorrect data';

        }//else

        return redirect('single-employee/'.$EmployeeID)->with( [ 'success' => $success, 'error' => $error ] );

    }//updateEmployee

    public function deleteEmployee(Request $request){

        $EmployeeID = $request->get('id');

        $error = 'Employee delete error';

        if($EmployeeID){

            if(!EmployeerHelper::ChangeChief($EmployeeID)){

                $error = 'Change chief error';

            }//if
            else{

                $employee = EmployeerHelper::getFullEmployee($EmployeeID);

                if($employee && $employee->employeeimg){

                    $ImgName = $employee->employeeimg->ImgName;

                    Storage::disk('public_img_employees')->delete($ImgName);

                }//if

                if(EmployeerHelper::deleteEmployee($EmployeeID) === true){

                    return redirect()->route('home');

                }//if

            }//else

        }//if

        return redirect('single-employee/'.$EmployeeID)->with( [ 'error' => $error ] );

    }//deleteEmployee

    public function changeChief(Request $request){

        $EmployeeID = $request->get('EmployeeID');
        $ChiefID = $request->get('ChiefID');
        $error = null;
        $success = null;
        $PositionID = 1;

        if($EmployeeID && $ChiefID){

            if($ChiefID == $EmployeeID){

                $error = 'Employee can not be yourself chief';

            }//if
            else{

                $chief = Employee::find($ChiefID);

                if(!$chief){

                    $error = 'Chief not found';

                }//if
                else{

                    $positionID = $chief->PositionID;

                    if($positionID == 5){

                        $error = 'Worker can not be Chief';

                    }//if
                    else{

                        $PositionID = $positionID + 1;

                        if(EmployeerHelper::ChangeChief($EmployeeID)){

                            DB::table('employees')->where('EmployeeID', '=', $EmployeeID)->update(['ChiefID' => $ChiefID, 'PositionID' => $PositionID]);

                        }//if
                        else{

                            $error = 'Change Chief Error';

                        }//else

                    }//else

                }//esle

            }//else

        }//if
        else{

            $error = 'Incorrect data';

        }//else

        if(!$error){

            $success = 'Chef successfully changed';

        }//if

        return redirect()->route('treeview')->with( [ 'success' => $success, 'error' => $error ] );

    }//changeChief

    public function logout(){

        Auth::logout();

        return redirect()->route('home');

    }//logout

}//AppController
