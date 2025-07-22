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
use App\Models\SCoordinator;
use App\Models\SCreditType;

class SSaleSeeder extends Seeder
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

                    // //Buscar el coordinador por nombre actual
                    // $s_coordinator = SCoordinator::where("name", trim($row[21]))->first();
                    // //Si no lo encuentra buscar por nombre antiguo
                    // if ($s_coordinator == null) {
                    //     $s_coordinator = SCoordinator::where("previous_name", trim($row[21]))->first();
                    //     if ($s_coordinator == null) {
                    //         $s_coordinator = SCoordinator::find(1);
                    //     }else {
                    //         $s_coordinator = SCoordinator::where("name", $s_coordinator->name)->first();
                    //     }
                    // }

                    $name = trim($row[21]);

                    // Buscar por el nombre actual (user.name)
                    $s_coordinator = SCoordinator::whereHas('user', function ($query) use ($name) {
                        $query->where('name', $name);
                    })->first();

                    // Si no lo encuentra, buscar en los nombres antiguos
                    if ($s_coordinator === null) {
                        $s_coordinator = SCoordinator::whereHas('coordinatorNames', function ($query) use ($name) {
                            $query->where('name', $name);
                        })->first();

                        // Si no lo encuentra por ningún nombre, usar el coordinador por defecto (id 1)
                        if ($s_coordinator === null) {
                            $s_coordinator = SCoordinator::find(1);
                        }
                    }

                    //Tengo que agregar el tipo de credito es, nuevo o restructura
                    $creditType = SCreditType::where("name", trim($row[12]))->first();
                
                    $f3 = ($row[29] - 25568) * 86400;
                    $grant_date = date('Y-m-d', $f3);
                    
                    if($sstatus->name !='Cancelado')
                    {
                        SSale::create([
                            'credit_id' => trim($row[1]), 
                            'client_name' => trim($row[6]),
                            'credit_amount' => trim($row[8]),
                            'opening_amount' => trim($row[9]),
                            'total_amount' => trim($row[8]) + trim($row[9]),
                            's_status_id' => $sstatus->id,
                            'grant_date' => $grant_date,
                            'institution_id' => $institution->id,
                            's_branch_id' => $sbranch->id,
                            's_credit_type_id' => $creditType->id,
                            's_coordinator_id' => $s_coordinator->id ?? 1
                        ]);
                    }
            }
        }
    }

}
