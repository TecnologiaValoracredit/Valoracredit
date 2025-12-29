<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Motive;
use App\Models\DiscountCharacteristic;

class MotiveAndDiscountCharacteristicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motive_values = [
            ['name' => 'Retardo justificado'],
            ['name' => 'Suspensión'],
            ['name' => 'Personal'],
            ['name' => 'Otro'],
        ];

        $discount_values = [
            ['name' => 'Rebaje por nómina'],
            ['name' => 'Tiempo por tiempo'],
            ['name' => 'Permiso con goce de sueldo'],
        ];

        foreach ($motive_values as $key => $motive_value) {
            Motive::create([
                'name' => $motive_value['name'],
            ]);
        }

        foreach ($discount_values as $key => $discount_value) {
            DiscountCharacteristic::create([
                'name' => $discount_value['name'],
            ]);
        }
    }
}
