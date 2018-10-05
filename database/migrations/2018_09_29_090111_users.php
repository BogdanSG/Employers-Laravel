<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable(false);
            $table->string('password')->nullable(false);
            $table->string('api_token', 60)->nullable(false);
            $table->rememberToken();

            $table->unique('username');
            $table->unique('api_token');
        });

    }//up

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('users');

    }//down

}//Users
