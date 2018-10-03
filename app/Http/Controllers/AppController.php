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

        return view('treeview');

    }//treeview

    public function singleEmployee($EmployeeID, $success = null, $error = null){

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

            if($employee){

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

                        $EmployeeImgID = EmployeerHelper::createOrUpdateImg($EmployeeID, $NewFileName);

                        if($EmployeeImgID){

                            $files = Storage::disk('public_img_employees')->allFiles();

                            foreach ($files as $f) {

                                if(pathinfo($f)['filename'] == $EmployeeID){

                                    Storage::disk('public_img_employees')->delete($f);

                                }//if

                            }//foreach

                            Storage::disk('public_img_employees')->putFileAs('/', $file, $NewFileName);

                        }//if

                    }//else

                }//if

            }//if

            if($ChiefID){

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

                if($employee->PositionID != $PositionID){

                    if(!EmployeerHelper::ChangeChief($EmployeeID)){

                        $error = 'Change chief error';

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

    public function logout(){

        Auth::logout();

        return redirect()->route('home');

    }//logout

}//AppController
