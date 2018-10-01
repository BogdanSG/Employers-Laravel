<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeImg extends Model {

    protected $table = 'employee_imgs';
    protected $primaryKey = 'EmployeeImgID';
    public $timestamps = false;

    public function employee(){

        return $this->belongsTo('App\Models\Employee', 'EmployeeImgID', 'EmployeeImgID');

    }//employee

}//EmployeeImg
