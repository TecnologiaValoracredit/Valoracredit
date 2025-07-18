<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\PermissionModule17072025Seeder;
use Database\Seeders\PermissionPermission17072025Seeder;
use Database\Seeders\Menu17072025Seeder;
use Illuminate\Database\Seeder;


class Database17072025Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionModule17072025Seeder::class,
            PermissionPermission17072025Seeder::class,
            Menu17072025Seeder::class,
        ]);
    }
}
