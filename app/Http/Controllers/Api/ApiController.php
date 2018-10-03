<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\EmployeerHelper;
use App\Models\Employee;
use App\Models\Position;

class ApiController extends Controller {

    public function treeEmployee(Request $request){

        $EmployeeID = $request->get('id');

        return response()->json(EmployeerHelper::getTreeEmployee($EmployeeID));

    }//treeEmployee

    public function newEmployeePositionChief(Request $request){

        $ChiefID = $request->get('id');

        $data = null;

        if($ChiefID){

            $chif = Employee::find($ChiefID);

            if($chif && $chif->PositionID < 5){

                $position = Position::find($chif->PositionID + 1);

                if($position){

                    $data = ['Chief' => ['FirstName' => $chif->FirstName, 'LastName' => $chif->LastName, 'SurName' => $chif->SurName, 'EmployeeID' => $chif->EmployeeID ], 'Position' => $position->Position];

                }//if

            }//if

        }//if

        return response()->json($data);

    }//newEmployeePositionChief

}//ApiController
