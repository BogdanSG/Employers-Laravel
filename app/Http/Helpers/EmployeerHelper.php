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

}//EmployeerHelper