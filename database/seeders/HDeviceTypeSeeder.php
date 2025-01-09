<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HDeviceType;

class HDeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HDeviceType :: create([
            'id'=>'1',
            'name'=>'Laptop',
            'description' => 'Computadora portátil'

        ]);

        HDeviceType :: create([
            'id'=>'2',
            'name'=>'Pc',
            'description' => 'Computadora de escritorio'

        ]);

        HDeviceType :: create([
            'id'=>'3',
            'name'=>'Celular',
            'description' => 'Telefono inteligente'

        ]);
    }
}
