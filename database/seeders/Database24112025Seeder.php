<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Database24112025Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TerminationReasonsSeeder::class,
            GendersAndCivilStatusesSeeder::class,
            Menu13112025Seeder::class,
            ContractTypesSeeder::class,
            ContractsSeeder::class,
            ContractVariableSeeder::class,
            UserContractSeeder::class,
        ]);
    }
}
