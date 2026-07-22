<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database22072026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionFunction22072026Seeder::class,
            PermissionPermission22072026Seeder::class,
            PermissionPermissionRole22072026Seeder::class,
        ]);
    }
}
