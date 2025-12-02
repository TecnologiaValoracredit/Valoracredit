<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database14112025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionModule14112025Seeder::class,
            PermissionPermission14112025Seeder::class,
            PermissionPermissionRole14112025Seeder::class,
            // JobPositionSeeder::class,
        ]);
    }
}
