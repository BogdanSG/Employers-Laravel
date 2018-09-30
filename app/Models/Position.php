<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model {

    protected $table = 'positions';
    protected $primaryKey = 'PositionID';
    public $timestamps = false;

    public function employee(){

        return $this->belongsTo('App\Models\Employee', 'PositionID', 'PositionID');

    }//employee

}//Position
