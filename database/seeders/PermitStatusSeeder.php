<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermitStatus;

class PermitStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Creado', 'description' => 'El permiso ha sido creado', 'color' => 'badge-secondary'],
            ['name' => 'Enviado', 'description' => 'El permiso ha sido enviado', 'color' => 'badge-primary'],
            ['name' => 'En revisión', 'description' => 'El permiso se encuentra en revisión', 'color' => 'badge-warning'],
            ['name' => 'Denegado', 'description' => 'El permiso ha sido denegado', 'color' => 'badge-danger'],
            ['name' => 'Aprobado', 'description' => 'El permiso ha sido aprobado', 'color' => 'badge-success'],
            ['name' => 'Cancelado', 'description' => 'El permiso ha sido cancelado', 'color' => 'badge-secondary'],
        ];

        foreach ($values as $key => $value) {
            PermitStatus::create([
                'name' => $value['name'],
                'description' => $value['description'],
                'color' => $value['color'],
            ]);
        }
    }
}
