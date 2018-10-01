<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;
use App\Http\Helpers\EmployeerHelper;

class AppController extends Controller {

    public function home(){

        return view('home');

    }//home

    public function treeview(){

        return view('treeview');

    }//treeview

    public function singleEmployee($EmployeeID){

        //dd(EmployeerHelper::getFullEmployee($EmployeeID));

        $employee = EmployeerHelper::getFullEmployee($EmployeeID);

        if($employee){

            $EmploymentDate = str_replace('Z', '', $employee->EmploymentDate);

            $EmploymentDate = str_replace(' ', 'T', $EmploymentDate);

            $imgPath = $employee->employeeimg ? '/img/employees/'.$employee->employeeimg->ImgName : '/img/user.png';

            return view('single-employee', ['ImgPath' => $imgPath, 'Employee' => $employee, 'EmploymentDate' => $EmploymentDate, 'MinSalaryValue' => 1000, 'MaxSalaryValue' => 1000000000]);

        }//if
        else{

            abort(404);

        }//else

    }//singleEmployee

    public function logout(){

        Auth::logout();

        return redirect()->route('home');

    }//logout

}//AppController
