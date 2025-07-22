<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SBranch;

class SBranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SBranch::create([
            'name'=> 'Sucursal de prueba credisoft 1',
        ]);
        SBranch::create([
            'name'=> 'Sucursal de prueba credisoft 2',
        ]);
    }
}
