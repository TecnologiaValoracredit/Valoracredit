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
            PermissionModule02122025Seeder::class,
            PermissionPermission02122025Seeder::class,
            PermissionPermissionRole02122025Seeder::class,
            Menu13112025Seeder::class,
        ]);
    }
}
