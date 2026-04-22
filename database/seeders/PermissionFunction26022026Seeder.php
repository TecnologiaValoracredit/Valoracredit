<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction26022026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'getFields', 'description' => 'Obtener los campos del Gasto Recurrente'],
            ['name' => 'updateStatus', 'description' => 'Actualizar estatus'],
        ];

        foreach($values as $key => $value){
            PermissionFunction::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }
    }
}
