<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gender;
use App\Models\CivilStatus;

class GendersAndCivilStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genderValues = [
            ['name' => 'Masculino'],
            ['name' => 'Femenino'],
        ];

        foreach ($genderValues as $key => $value) {
            Gender::create([
                'name'=> $value['name'],
            ]);
        }

        $civilStatusesValues = [
            ['name' => 'Soltero/a'],
            ['name' => 'Casado/a'],
            ['name' => 'Divorciado/a'],
            ['name' => 'Viudo/a'],
            ['name' => 'Separado/a'],
            ['name' => 'Unión de hecho o concubinato'],
        ];

        foreach ($civilStatusesValues as $key => $value) {
            CivilStatus::create([
                'name' => $value['name'],
            ]);
        }
    }
}
