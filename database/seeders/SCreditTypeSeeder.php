<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SCreditType;

class SCreditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SCreditType::create([
            'name'=> 'Nuevo'
        ]);
        SCreditType::create([
            'name'=> 'Reestructura'
        ]);
    }
}
