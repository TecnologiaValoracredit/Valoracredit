<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database24122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //Seeders para creación del modulo de permisos
            PermissionModule09122025Seeder::class,
            PermissionFunction09122025Seeder::class,
            PermissionPermission09122025Seeder::class,
            PermissionPermissionRole09122025Seeder::class,
            Menu09122025Seeder::class,

            //Seeders de Permisos
            MotiveAndDiscountCharacteristicSeeder::class,
            PermitStatusSeeder::class,
            PermitSeeder::class,
        ]);
    }
}
