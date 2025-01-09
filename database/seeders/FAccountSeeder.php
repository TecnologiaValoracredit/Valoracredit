<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FAccount;

class FAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FAccount::create([
            "name" => "BIM 2017",
            "account" => "XXXX",
            "balance" => 0
        ]);
        FAccount::create([
            "name" => "BIM 2018",
            "account" => "XXXX",
            "balance" => 0
        ]);
        FAccount::create([
            "name" => "WS Santander",
            "account" => "XXXX",
            "balance" => 0
        ]);
        FAccount::create([
            "name" => "WS BBVA",
            "account" => "XXXX",
            "balance" => 0
        ]);
        FAccount::create([
            "name" => "STP",
            "account" => "XXXX",
            "balance" => 0
        ]);
    }
}
