<?php

namespace Database\Seeders;

use App\Models\FClasification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FCobClasificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $f = FClasification::create([
            "name" => "Fondeo Fimubac",
            "f_movement_type_id" => 1
        ]);

        FClasification::create([
            "name" => "Fondeo Fimubac",
            "parent_id" => $f->id,
            "f_movement_type_id" => 1
        ]);

        $f = FClasification::create([
            "name" => "Personas Fisicas",
            "f_movement_type_id" => 1
        ]);

        FClasification::create([
            "name" => "Personas Fisicas",
            "parent_id" => $f->id,
            "f_movement_type_id" => 1
        ]);

        
       
    }
}
