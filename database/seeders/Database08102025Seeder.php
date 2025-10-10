<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\PermissionModule25062025Seeder;
use Database\Seeders\PermissionPermission25062025Seeder;
use Database\Seeders\Menu25062025Seeder;
use Illuminate\Database\Seeder;


class Database08102025Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionModule08102025Seeder::class,
            PermissionPermission08102025Seeder::class,
            Menu08102025Seeder::class,
        ]);
    }
}
