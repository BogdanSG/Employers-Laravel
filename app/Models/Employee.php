<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

    protected $table = 'employees';
    protected $primaryKey = 'EmployeeID';
    public $timestamps = false;

    public function position(){

        return $this->hasOne('App\Models\Position', 'PositionID', 'PositionID');

    }//positions

}//Employee
