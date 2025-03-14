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
            "account_number" => "65505363166",
            "f_company_id" => 2,
            "init_balance" => 10000,
        ]);
        FAccount::create([
            "name" => "BIM 2018",
            "account_number" => "65506825794",
            "f_company_id" => 2,
            "init_balance" => 10000,

        ]);
        FAccount::create([
            "name" => "WS SANTANDER",
            "account_number" => "65508893317",
            "f_company_id" => 1,
            "init_balance" => 6534682.15,

        ]);
        FAccount::create([
            "name" => "WS BBVA",
            "account_number" => "0119041974",
            "f_company_id" => 1,
            "init_balance" => 4416.15,

        ]);
        FAccount::create([
            "name" => "STP",
            "account_number" => "646180315700000007",
            "f_company_id" => 1,
            "init_balance" => 344030.85,

        ]);
    }
}
