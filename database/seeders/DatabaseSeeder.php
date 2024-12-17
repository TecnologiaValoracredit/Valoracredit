<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\PermissionModuleSeeder;
use Database\Seeders\PermissionFunctionSeeder;
use Database\Seeders\PermissionPermissionSeeder;
use Database\Seeders\PermissionPermissionRoleSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\ModuleTypeSeeder;
use Database\Seeders\DepartamentSeeder;

use Database\Seeders\InstitutionSeeder;
use Database\Seeders\AnchorerSeeder;
use Database\Seeders\ExpStatusSeeder;
use Database\Seeders\UbiStatusSeeder;
use Database\Seeders\ExpTypeSeeder;
use Database\Seeders\UbicationSeeder;
use Database\Seeders\ExpedientSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            DepartamentSeeder::class,
            UserSeeder::class,
            
            ModuleTypeSeeder::class,
            PermissionModuleSeeder::class,
            PermissionFunctionSeeder::class,
            PermissionPermissionSeeder::class,
            PermissionPermissionRoleSeeder::class,
            MenuSeeder::class,
            InstitutionSeeder::class,
            AnchorerSeeder::class,
            ExpStatusSeeder::class,
            UbiStatusSeeder::class,
            ExpTypeSeeder::class,
            UbicationSeeder::class,
            ExpedientSeeder::class,
        ]);
    }
}
