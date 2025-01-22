<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FCompany;

class FCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FCompany::create([
            "name" => "WS Promotora",
        ]);
        FCompany::create([
            "name" => "Plan IP",
        ]);
    }
}
