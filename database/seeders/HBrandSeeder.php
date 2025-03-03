<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HBrand;

class HBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HBrand :: create([
            'id'=>'1',
            'name'=>'Hp',
            
        ]);

        HBrand :: create([
            'id'=>'2',
            'name'=>'Lenovo',
        ]);

        HBrand :: create([
            'id'=>'3',
            'name'=>'Dell',
        ]);
        HBrand :: create([
            'id'=>'4',
            'name'=>'MSI',
        ]);

        HBrand :: create([
            'id'=>'5',
            'name'=>'Apple',
        ]);

        HBrand :: create([
            'id'=>'100',
            'name'=>'Otro',
        ]);
    }
}
