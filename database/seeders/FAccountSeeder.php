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
            "account_number" => "XXXX",
            "f_company_id" => 2,
            "init_balance" => 200000,
        ]);
        FAccount::create([
            "name" => "BIM 2018",
            "account_number" => "XXXX",
            "f_company_id" => 2,
            "init_balance" => 200000,

        ]);
        FAccount::create([
            "name" => "WS SANTANDER",
            "account_number" => "XXXX",
            "f_company_id" => 1,
            "init_balance" => 200000,

        ]);
        FAccount::create([
            "name" => "WS BBVA",
            "account_number" => "XXXX",
            "f_company_id" => 1,
            "init_balance" => 200000,

        ]);
        FAccount::create([
            "name" => "STP",
            "account_number" => "XXXX",
            "f_company_id" => 1,
            "init_balance" => 200000,

        ]);
    }
}
