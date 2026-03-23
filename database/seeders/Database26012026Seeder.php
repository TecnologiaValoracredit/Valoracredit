<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database26012026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                PermissionModule12022026Seeder::class,
                PermissionFunction26012026Seeder::class,
                PermissionPermission26012026Seeder::class,
                PermissionPermissionRole26012026Seeder::class,
                Menu12022026Seeder::class,

                RequisitionModuleDependenciesSeeder::class,
            ]
        );
    }
}
