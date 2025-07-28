<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database18072025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionModule18072025Seeder::class,
            PermissionPermission18072025Seeder::class,
            MenuSeeder::class,
            Menu18072025Seeder::class,
            SBranchSeeder::class,
        ]);
    }
}
