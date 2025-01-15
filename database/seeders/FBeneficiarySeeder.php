<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FBeneficiary;

class FBeneficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FBeneficiary::create([
            "name" => "Benef1",
        ]);
        FBeneficiary::create([
            "name" => "Benef2",
        ]);
    }
}
