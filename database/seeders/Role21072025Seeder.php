<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class Role21072025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => 13,
            'name'=> 'Cooridnador',
        ]);
       Role::create([
            'id' => 14,
            'name'=> 'Promotor',
        ]);
    }
}
