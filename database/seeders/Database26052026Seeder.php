<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database26052026Seeder extends Seeder
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
            PermissionModule26052026Seeder::class,
            // PermissionFunction26052026Seeder::class,
            PermissionPermission26052026Seeder::class,
            PermissionPermissionRole26052026Seeder::class,
            Menu26052026Seeder::class,
        ]);
    }
}
