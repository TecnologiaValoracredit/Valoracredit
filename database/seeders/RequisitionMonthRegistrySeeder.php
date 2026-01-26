<?php

namespace Database\Seeders;

use App\Models\RequisitionMonthRegistry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequisitionMonthRegistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequisitionMonthRegistry::create([
            'last_index' => '00',
        ]);
    }
}
