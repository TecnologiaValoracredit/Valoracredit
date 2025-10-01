<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\PermissionModule25062025Seeder;
use Database\Seeders\PermissionPermission25062025Seeder;
use Database\Seeders\Menu25062025Seeder;
use Illuminate\Database\Seeder;


class Database21082025Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionModule21082025Seeder::class,
            PermissionPermission21082025Seeder::class,
        ]);
    }
}
