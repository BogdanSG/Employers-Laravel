<?php

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeesSeeder extends Seeder {

    static private $countEmployeers = 50000; //+-10%

    static private $firstNameArr = [
        'Александр',
        'Сергей',
        'Владимир',
        'Алексей',
        'Николай',
        'Андрей',
        'Виктор',
        'Юрий',
        'Дмитрий',
        'Иван',
        'Борис',
        'Николай',
        'Константин',
        'Евгений'
    ];

    static private $lastNameArr = [
        'Смирнов',
        'Иванов',
        'Кузнецов',
        'Соколов',
        'Попов',
        'Лебедев',
        'Козлов',
        'Новиков',
        'Морозов',
        'Петров',
        'Волков',
        'Соловьёв',
        'Васильев',
        'Зайцев',
        'Павлов',
        'Семёнов',
        'Голубев',
        'Виноградов',
        'Богданов',
        'Воробьёв',
        'Фёдоров',
        'Михайлов',
        'Беляев',
        'Тарасов',
        'Белов',
    ];

    static private $surNameArr = [
        'Александрович',
        'Сергеевич',
        'Владимирович',
        'Алексеевич',
        'Николаевич',
        'Андреевич',
        'Викторович',
        'Юрьевич',
        'Дмитриевич',
        'Иваныч',
        'Борисович',
        'Николаевич',
        'Константинович',
        'Евгеньевич'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $countDirectors = round(EmployeesSeeder::$countEmployeers * 0.001); //0.1%

        $countChief = round(EmployeesSeeder::$countEmployeers * 0.05); //5%

        $countMainWorker = round(EmployeesSeeder::$countEmployeers * 0.15); //15%

        $countForeman = round(EmployeesSeeder::$countEmployeers * 0.25); //35%

        $countWorker = round(EmployeesSeeder::$countEmployeers * 0.449); //44.9%

        $TempIDS = 1;

        for($i = 0; $i < $countDirectors; $i++){

            Employee::create([
                'PositionID' => 1,
                'FirstName' => EmployeesSeeder::$firstNameArr[rand(0, count(EmployeesSeeder::$firstNameArr) - 1)],
                'LastName' => EmployeesSeeder::$lastNameArr[rand(0, count(EmployeesSeeder::$lastNameArr) - 1)],
                'SurName' => EmployeesSeeder::$surNameArr[rand(0, count(EmployeesSeeder::$surNameArr) - 1)],
                'Salary' => (rand(1000, 5000) * 100)
            ]);

        }//for

        for($i = 0; $i < $countChief; $i++){

            Employee::create([
                'ChiefID' => rand($TempIDS, $countDirectors),
                'PositionID' => 2,
                'FirstName' => EmployeesSeeder::$firstNameArr[rand(0, count(EmployeesSeeder::$firstNameArr) - 1)],
                'LastName' => EmployeesSeeder::$lastNameArr[rand(0, count(EmployeesSeeder::$lastNameArr) - 1)],
                'SurName' => EmployeesSeeder::$surNameArr[rand(0, count(EmployeesSeeder::$surNameArr) - 1)],
                'Salary' => (rand(500, 3000) * 100)
            ]);

        }//for

        $TempIDS = $countDirectors;

        for($i = 0; $i < $countMainWorker; $i++){

            Employee::create([
                'ChiefID' => rand($TempIDS, $TempIDS + $countChief),
                'PositionID' => 3,
                'FirstName' => EmployeesSeeder::$firstNameArr[rand(0, count(EmployeesSeeder::$firstNameArr) - 1)],
                'LastName' => EmployeesSeeder::$lastNameArr[rand(0, count(EmployeesSeeder::$lastNameArr) - 1)],
                'SurName' => EmployeesSeeder::$surNameArr[rand(0, count(EmployeesSeeder::$surNameArr) - 1)],
                'Salary' => (rand(300, 1000) * 100)
            ]);

        }//for

        $TempIDS += $countChief;

        for($i = 0; $i < $countForeman; $i++){

            Employee::create([
                'ChiefID' => rand($TempIDS, $TempIDS + $countMainWorker),
                'PositionID' => 4,
                'FirstName' => EmployeesSeeder::$firstNameArr[rand(0, count(EmployeesSeeder::$firstNameArr) - 1)],
                'LastName' => EmployeesSeeder::$lastNameArr[rand(0, count(EmployeesSeeder::$lastNameArr) - 1)],
                'SurName' => EmployeesSeeder::$surNameArr[rand(0, count(EmployeesSeeder::$surNameArr) - 1)],
                'Salary' => (rand(200, 800) * 100)
            ]);

        }//for

        $TempIDS += $countMainWorker;

        for($i = 0; $i < $countWorker; $i++){

            Employee::create([
                'ChiefID' => rand($TempIDS, $TempIDS + $countForeman),
                'PositionID' => 5,
                'FirstName' => EmployeesSeeder::$firstNameArr[rand(0, count(EmployeesSeeder::$firstNameArr) - 1)],
                'LastName' => EmployeesSeeder::$lastNameArr[rand(0, count(EmployeesSeeder::$lastNameArr) - 1)],
                'SurName' => EmployeesSeeder::$surNameArr[rand(0, count(EmployeesSeeder::$surNameArr) - 1)],
                'Salary' => (rand(100, 600) * 100)
            ]);

        }//for

    }//run

}//EmployeesSeeder
