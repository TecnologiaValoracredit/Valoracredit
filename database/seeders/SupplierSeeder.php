<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;


class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'name'=> 'Pcel',
            'description' =>'Tienda de tecnología'
        ]);

        Supplier::create([
            'name'=> 'Steren',
            'description' =>'Tienda de tecnología'
        ]);

        Supplier::create([
            'name'=> 'Cyberpuerta',
            'description' =>'Tienda de tecnología en linea'
        ]);

        Supplier::create([
            'name'=> 'Radioshack',
            'description' =>'Tienda de tecnología'
        ]);


    }
}
