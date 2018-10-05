<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        User::create(['username' => 'admin', 'password' => bcrypt('admin'), 'api_token' => bin2hex(openssl_random_pseudo_bytes(30))]);

    }//run

}//UsersSeeder
