<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction09122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionFunction::create(['name' => 'seeAllPermits', 'description' => 'Ver todos los permisos generados por usuarios']);
        PermissionFunction::create(['name' => 'seeUserPermits', 'description' => 'Ver los permisos generados por el usuario actual']);
    }
}
