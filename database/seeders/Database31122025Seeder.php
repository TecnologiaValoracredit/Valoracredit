<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database31122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionFunction31122025Seeder::class,
            PermissionPermission31122025Seeder::class,
            PermissionPermissionRole31122025Seeder::class,
        ]);
    }
}
