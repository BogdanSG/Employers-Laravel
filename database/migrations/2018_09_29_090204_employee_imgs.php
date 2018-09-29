<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmployeeImgs extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('employee_imgs', function (Blueprint $table) {
            $table->increments('EmployeeImgID');
            $table->string('ImgName')->nullable(false);
        });

    }//up

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('employee_imgs');

    }//down
}
