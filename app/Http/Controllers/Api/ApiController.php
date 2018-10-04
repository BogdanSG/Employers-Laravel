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

    public function employeeList(Request $request){

        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $orderBy = $request->get('orderBy');
        $sort = $request->get('sort');
        $search = $request->get('search');
        $searchValue = $request->get('searchValue');

        $employees = Employee::with('position')->with('employeeimg');

        if($search && $searchValue){

            if($search === 'FirstName' || $search === 'LastName' || $search === 'SurName'){

                $employees = $employees->where($search, 'LIKE', "${searchValue}%");

            }//if
            else{

                $employees = $employees->where($search, '=', $searchValue);

            }//else

        }//if

        $employees = $employees->orderBy($orderBy, $sort)->offset($offset)->limit($limit)->get();

        return response()->json($employees);

    }//employeeList

}//ApiController
