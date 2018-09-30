<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\EmployeerHelper;

class ApiController extends Controller {

    public function treeEmployee(Request $request){

        $EmployeeID = $request->get('id');

        return response()->json(EmployeerHelper::getTreeEmployee($EmployeeID));

    }//treeEmployee

}//ApiController
