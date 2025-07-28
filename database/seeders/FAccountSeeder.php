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
       $f_accounts = array(
        array('id' => '6','name' => 'BIM 2017','account_number' => '65505363166','init_balance' => '10000.00','f_company_id' => '2','created_at' => '2025-03-14 11:13:00','updated_at' => '2025-03-14 11:13:00','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '7','name' => 'BIM 2018','account_number' => '65506825794','init_balance' => '10000.00','f_company_id' => '2','created_at' => '2025-03-14 11:13:00','updated_at' => '2025-03-14 11:13:00','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '8','name' => 'WS SANTANDER','account_number' => '65508893317','init_balance' => '6534682.15','f_company_id' => '1','created_at' => '2025-03-14 11:13:01','updated_at' => '2025-03-14 11:13:01','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '9','name' => 'WS BBVA','account_number' => '0119041974','init_balance' => '4416.15','f_company_id' => '1','created_at' => '2025-03-14 11:13:01','updated_at' => '2025-03-14 11:13:01','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL),
        array('id' => '10','name' => 'STP','account_number' => '646180315700000007','init_balance' => '344030.85','f_company_id' => '1','created_at' => '2025-03-14 11:13:01','updated_at' => '2025-03-14 11:13:01','notes' => NULL,'is_active' => '1','created_by' => NULL,'updated_by' => NULL)
        );
        foreach ($f_accounts as $key => $f_account) {
            FAccount::create([
                'id' => $f_account["id"],
                'name' => $f_account["name"], 
                'account_number' => $f_account["account_number"], 
                'init_balance' => $f_account["init_balance"], 
                'f_company_id' => $f_account["f_company_id"], 
                'created_at' => $f_account["created_at"],
                'updated_at' => $f_account["updated_at"], 
                'is_active' => $f_account["is_active"], 
            ]);
        }
    }
}
