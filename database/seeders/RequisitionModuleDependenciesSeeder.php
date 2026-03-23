<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequisitionModuleDependenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RequisitionStatus08012026Seeder::class,
            RequisitionGlobalStatusSeeder::class,
            ExpenseTypeSeeder::class,
            ExpenseDurationSeeder::class,
        ]);
    }
}
