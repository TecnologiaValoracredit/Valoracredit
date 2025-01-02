<?php

namespace Database\Seeders;

use App\Models\SSale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;
use App\Models\Institution;
use App\Models\SBranch;
use App\Models\SStatus;

class SsaleSeeder extends Seeder
{
    /**
     * Run the database seeds. 
     *
     * @return void
     */
    public function run()
    {
        
        
        $file = base_path("resources/reporte_ventas.xlsx");
        $pages = Excel::toArray(new ExcelImport(), $file); 
        SBranch::create(["name" => "TORREON"]);
        foreach($pages[0] as $key =>$row)
        {
            if ($key > 0) {
                    $institution = Institution::where("name", trim($row[19]))->first();
                    if ($institution == null) {
                        $institution = Institution::create(["name" => trim($row[19])]);
                    }

                    $sbranch = SBranch::where("name", trim($row[22]))->first();
                    if ($sbranch == null) {
                        $sbranch = SBranch::create(["name" => trim($row[22])]);
                    }

                    $sstatus = SStatus::where("name", trim($row[34]))->first();
                    if ($sstatus == null) {
                        $sstatus = SStatus::create(["name" => trim($row[34])]);
                    }

                    if (($institution->name == "SECCION 5" || $institution->name == "SECCION 38") && $sbranch->name != "SALTILLO"){
                        $sbranch = SBranch::where("name", "TORREON")->first();
                    }
                
                    $f3 = ($row[29] - 25569) * 86400;
                    $grant_date = date('Y-m-d', $f3);

                    if($sstatus->name !='Cancelado')
                    {
                        
                        
                        SSale::create([
                        
                            'credit_id' => trim($row[1]), 
                            'client_name' => trim($row[6]),
                            'credit_amount' => trim($row[8]),
                            'sstatus_id' => $sstatus->id,
                            'grant_date' => $grant_date,
                            'institution_id' => $institution->id,
                            'sbranch_id' => $sbranch->id
                        ]);
                    }
           
                   
                       
                   

                   
                    

            }
        }
    }

}
