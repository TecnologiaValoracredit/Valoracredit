<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SCoordinator;

class SCoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SCoordinator :: create([
            'id'=>'1',
            'name'=>'Sin coordinador',
        ]);
    }
}
