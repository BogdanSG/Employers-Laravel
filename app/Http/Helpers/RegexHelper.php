<?php

namespace App\Http\Helpers;

class RegexHelper {

    public static function EmployeeName(){

        return '/^[^0-9)([\]<>\\\\\/.{},\'":;`$~#@!%^&*+=|?_-]{1,255}$/mi';

    }//EmployeeName

    public static function EmployeeDate(){

        return '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}(:\d{2}){0,1}$/mi';

    }//EmployeeDate

    public static function IsMatch($value, $pattern){

        if(preg_match($pattern, $value)){

            return true;

        }//if
        else{

            return false;

        }//esle

    }//IsMatch

}//RegexHelper