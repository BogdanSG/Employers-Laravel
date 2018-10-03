<?php


namespace App\Http\Helpers;
use App\Models\Employee;
use App\Models\EmployeeImg;
use App\Models\Position;
use App\Models\User;
use \DB;
use \Exception;

class EmployeerHelper {

    public static function getTreeEmployee($EmployeeID){

        $data = [];

        try{

            if($EmployeeID){

                return DB::select('
                                    SELECT e.EmployeeID, e.FirstName, e.LastName, e.SurName, p.PositionID, p.Position, (SELECT COUNT(*) FROM `employees` AS ee WHERE ee.ChiefID = e.EmployeeID) as CountEmployees
                                    FROM `employees` AS e
                                    JOIN `positions` AS p ON p.PositionID = e.PositionID
                                    WHERE e.ChiefID = :EmployeeID
                                ', [ 'EmployeeID' => $EmployeeID ]);

            }//if
            else{

//                Employee::with('position')
//                    ->addSelect(DB::raw('(SELECT COUNT(*) FROM `employees` AS ee WHERE ee.ChiefID = e.EmployeeID) as CountEmployees')
//                    ->where('PositionID', '=', 1)
//                    ->get();
//                COUNT NOT WORK!!!

                return DB::select('
                                    SELECT e.EmployeeID, e.FirstName, e.LastName, e.SurName, p.PositionID, p.Position, (SELECT COUNT(*) FROM `employees` AS ee WHERE ee.ChiefID = e.EmployeeID) as CountEmployees
                                    FROM `employees` AS e
                                    JOIN `positions` AS p ON p.PositionID = e.PositionID
                                    WHERE e.PositionID = 1
                                ');

            }//else

        }//try
        catch (Exception $ex){

        }//catch

        return $data;

    }//getTreeEmployee

    public static function getFullEmployee($EmployeeID){

        if($EmployeeID){

            return Employee::with('position')->with('employeeimg')->with('chief')->find($EmployeeID);

        }//if
        else{

            return null;

        }//else

    }//getFullEmployee

    public static function deleteEmployee($EmployeeID){

        if($EmployeeID){

            $employee = Employee::find($EmployeeID);

            if($employee){

                $EmployeeImgID = $employee->EmployeeImgID;

                DB::table('employees')->where('EmployeeID', '=', $EmployeeID)->delete();

                if($EmployeeImgID){

                    DB::table('employee_imgs')->where('EmployeeImgID', '=', $EmployeeImgID)->delete();

                }//if

                return true;

            }//if

        }//if

        return false;

    }//deleteEmployee

    public static function createOrUpdateImg($EmployeeID, $ImgName){

        if($EmployeeID && $ImgName){

            $employee = Employee::find($EmployeeID);

            if($employee){

                $EmployeeImgID = $employee->EmployeeImgID;

                if($EmployeeImgID){

                    DB::table('employee_imgs')->where('EmployeeImgID', '=', $EmployeeImgID)->update(['ImgName' => $ImgName]);

                }//if
                else{

                    $EmployeeImgID = DB::table('employee_imgs')->insertGetId(['ImgName' => $ImgName]);

                    DB::table('employees')->where('EmployeeID', '=', $EmployeeID)->update(['EmployeeImgID' => $EmployeeImgID]);

                }//else

                return $EmployeeImgID;

            }//if

        }//if

        return null;

    }//createOrUpdateImg

    public static function ChangeChief($EmployeeID){

        $Employees = Employee::where('ChiefID', '=', $EmployeeID)->get(['EmployeeID']);

        if(!$Employees){

            return false;

        }//if
        else if(count($Employees) == 0){

            return true;

        }//else if

        $Employee = Employee::find($EmployeeID);

        if(!$Employee){

            return false;

        }//if

        if(count($Employees) > 0){

            $ChiefsIds = Employee::where('PositionID', '=', $Employee->PositionID)->get(['EmployeeID']);

            $EmployeesLength = count($Employees);
            $ChiefsIdsLength = count($ChiefsIds);

            for($i = 0; $i < $EmployeesLength; $i++){

                do {

                    $RandomChief = $ChiefsIds[rand(0, $ChiefsIdsLength - 1)]->EmployeeID;

                } while ($EmployeeID == $RandomChief);

                DB::table('employees')->where('EmployeeID', '=', $Employees[$i]->EmployeeID)->update(['ChiefID' => $RandomChief]);

            }//for

            return true;

        }//if

        return false;

    }//ChangeChief

}//EmployeerHelper