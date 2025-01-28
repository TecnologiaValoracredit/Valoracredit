<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'name'=> 'Monterrey',
        ]);
        Branch::create([
            'name'=> 'Satillo',
        ]);
        Branch::create([
            'name'=> 'Torreon',
        ]);
        Branch::create([
            'name'=> 'Villahermosa',
        ]);
    }
}
