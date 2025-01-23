<?php

namespace Database\Seeders;

use App\Models\FFlux;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use App\Models\FBeneficiary;
use App\Models\FAccount;
use App\Models\FClasification;
use Illuminate\Support\Facades\DB;

class FFluxSeeder extends Seeder
{
    /**
     * Run the database seeds. 
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FFlux::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file = base_path("resources/flujos-enero2025.xlsx");
        $pages = Excel::toArray(new ExcelImport(), $file); 

        foreach($pages[0] as $key =>$row)
        {
            $f_beneficiary = FBeneficiary::where("name", trim($row[2]))->first();
            if ($f_beneficiary == null) {
                $f_beneficiary = FBeneficiary::create(["name" => trim($row[2])]);
            }

            $account = FAccount::where("name", trim($row[0]))->first();
        
            $f = ($row[1] - 25568) * 86400;
            $date = date('Y-m-d', $f);

            $amount = $row[5];
            $m_type_id = 1;
            if ($row[4] > 0) {
                $amount = $row[4];
                $m_type_id = 2;
            }

            $f_clasification = FClasification::whereRaw("UPPER(name) = ?", [strtoupper(trim($row[6]))])->whereNotNull("parent_id")->first();
            
            FFlux::create([
                'f_account_id'  => $account->id,
                'accredit_date' => $date,
                'f_beneficiary_id' => $f_beneficiary->id,
                'concept' => trim($row[3]),
                'amount' => $amount,
                'f_movement_type_id' => $m_type_id,
                'f_status_id' => 1,
                'f_clasification_id' => $f_clasification->id ?? null,
            ]);
           
        }
    }

}
