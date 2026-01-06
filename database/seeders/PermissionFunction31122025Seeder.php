<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionFunction;

class PermissionFunction31122025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionFunction::create(['name' => 'setNewSignature', 'description' => 'Permiso para cambiar la firma de un usuario']);
    }
}
