<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\PermissionModule25062025Seeder;
use Database\Seeders\PermissionPermission25062025Seeder;
use Database\Seeders\Menu25062025Seeder;
use Illuminate\Database\Seeder;


class Database29072025Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionFunction29072025Seeder::class,
            PermissionPermission29072025Seeder::class,
        ]);
    }
}
