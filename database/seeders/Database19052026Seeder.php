<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database19052026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionModule19052026Seeder::class, //LISTO
            PermissionFunction19052026Seeder::class, //LISTO
            PermissionPermission19052026Seeder::class, //LISTO
            PermissionPermissionRole19052026Seeder::class, //LISTO
            Menu19052026Seeder::class, //LISTO
            VacationStatusSeeder::class, //LISTO
            VacationPolicySeeder::class, //LISTO
        ]);
    }
}
