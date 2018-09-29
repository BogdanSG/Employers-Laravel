<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Employees extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('EmployeeID');
            $table->integer('ChiefID')->nullable(true)->unsigned();
            $table->integer('PositionID')->nullable(false)->unsigned();
            $table->integer('EmployeeImgID')->nullable(true)->unsigned();
            $table->string('FirstName')->nullable(false);
            $table->string('LastName')->nullable(false);
            $table->string('SurName')->nullable(true);
            $table->dateTime('EmploymentDate')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->double('Salary')->nullable(false);

            $table->foreign('ChiefID')->references('EmployeeID')->on('employees');
            $table->foreign('PositionID')->references('PositionID')->on('positions');
            $table->foreign('EmployeeImgID')->references('EmployeeImgID')->on('employee_imgs');
        });

    }//up

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('employees');
    }//down

}//Employees
