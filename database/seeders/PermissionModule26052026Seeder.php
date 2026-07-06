<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModule26052026Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $min = PermissionModule::firstOrCreate(
            ['name' => 'min', 'parent_id' => null],
            ['description' => 'Minutas', 'module_type_id' => 1]
        );

        PermissionModule::firstOrCreate(
            ['name' => 'minutes', 'parent_id' => $min->id],
            ['description' => 'Minutas', 'module_type_id' => 2]
        );
    }
}
