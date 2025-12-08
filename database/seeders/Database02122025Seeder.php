<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database02122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TerminationReasonsSeeder::class,
            GendersAndCivilStatusesSeeder::class,
            // ContractTypesSeeder::class,
            ContractVariableSeeder::class,

            PermissionFunction02122025Seeder::class,

            PermissionModule14112025Seeder::class,
            PermissionPermission14112025Seeder::class,
            PermissionPermissionRole14112025Seeder::class,

            PermissionModule02122025Seeder::class,
            PermissionPermission02122025Seeder::class,
            PermissionPermissionRole02122025Seeder::class,
            Menu13112025Seeder::class,
        ]);
    }
}
