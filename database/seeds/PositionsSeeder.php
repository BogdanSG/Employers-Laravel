<?php

use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionsSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        Position::create(['Position' => 'Director']);
        Position::create(['Position' => 'Chief']);
        Position::create(['Position' => 'Main Worker']);
        Position::create(['Position' => 'Foreman']);
        Position::create(['Position' => 'Worker']);

    }//run

}//PositionsSeeder
