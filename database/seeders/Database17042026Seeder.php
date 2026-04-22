<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database17042026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            Menu17042026Seeder::class, //Agrega nuevo modulo de Gastos Recurrentes
            RequisitionStatus20042026Seeder::class, //Actualiza los badges que llevará para su color de estatus
            RequisitionGlobalStatus20042026Seeder::class, //Actualiza los badges que llevará para su color de estatus
            PermissionPermission16042026Seeder::class //Agrega el permiso de devolver una requisición global de lista para D.G. a Revisada
        ]);
    }
}
