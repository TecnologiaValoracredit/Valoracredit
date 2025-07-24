<?php

namespace App\Imports;

use App\Models\Commission;
use App\Models\Institution;
use App\Models\SSale;
use App\Models\SPromotor;
use App\Models\SCoordinator;
use App\Models\SBranch;
use App\Models\SStatus;
use App\Models\SCreditType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;

class SalesImport implements ToCollection,
WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return SSale|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {

            $institution = null;
            $sBranch = null;
            $sStatus = null;
            $sCreditType = null;
            $coordinator = null;
            $promotor = null;

            // dd($row);
            // Buscar o crear institucion
            $institutionRow = $row["institucion"];
            $institution = Institution::where("name", $institutionRow)->first();
            if($institution == null) {
                $institution = Institution::create(["name" => $institutionRow]);
            }

            //Buscar o crear sucursal
            $sBranchRow = $row["sucursal"];
            $sBranch = SBranch::where("name", $sBranchRow)->first();
            if($sBranch == null) {
                $sBranch = SBranch::create(["name"=> $sBranchRow]);
            }

            //Lógica de negocio, si las instituciones son Secc 5 || 38 y sucursal no es Saltillo, se asigna Torreon (? lol)
            if (($institution->name == "SECCION 5" || $institution->name == "SECCION 38") && $sBranch->name != "SALTILLO"){
                dd($institution, $sBranch);
                $sBranch = SBranch::where("name", "TORREON")->first();
            }

            //Buscar o crear Status
            $sStatusRow = $row["estatuscredito"];
            $sStatus = SStatus::where("name", $sStatusRow)->first();
            if($sStatus == null) {
                $sStatus = SStatus::create(["name"=> $sStatusRow]);
            }

            //Buscar o crear Credit Type 
            $sCreditTypeRow = $row["tipocredito"];
            $sCreditType = SCreditType::where("name", $sCreditTypeRow)->first();
            if($sCreditType == null) {
                $sCreditType = SCreditType::create(["name"=> $sCreditTypeRow]);
            }

            //Buscar o crear coordiandor
            $coordinatorRow = $row["coordinador"];
            if(empty($coordinatorRow)) {
                //Verificar que el id corresponda al usuario "No coordinador"
                $coordinator = SCoordinator::where("user_id", 16)->first();
            }else{
                $coordinator = SCoordinator::whereHas('user', function ($query) use ($coordinatorRow) {
                    $query->where('name', $coordinatorRow);
                })->orWhereHas('coordinatorNames', function ($query) use ($coordinatorRow) {
                    $query->where('name', $coordinatorRow);
                })->first();
                if(empty($coordinator)) {
                    //Lanzar error de coordinador no encontrado
                    throw new \Exception("Coordinador con nombre '$coordinatorRow' no encontrado.");

                }
            }

            //Buscar o crear promotor
            $promotorRow = $row["promotor"];

            if (empty($promotorRow)) {
                // Asignar usuario "No promotor"
                $promotor = SPromotor::where('user_id', 17)->first();
                
                if (!$promotor) {
                    throw new \Exception("Promotor por defecto (ID: 17) no encontrado.");
                }
            } else {
                // Buscar por nombre actual o nombres anteriores
                $promotor = SPromotor::whereHas('user', function ($query) use ($promotorRow) {
                    $query->where('name', $promotorRow);
                })->orWhereHas('promotorNames', function ($query) use ($promotorRow) {
                    $query->where('name', $promotorRow);
                })->first();

                if (!$promotor) {
                    throw new \Exception("Promotor con nombre '$promotorRow' no encontrado.");
                }
            }
            $f3 = (trim($row["fechaotorgamiento"]) - 25568) * 86400;
            $grant_date = date('Y-m-d', $f3);
            
            if($sStatus->name !='Cancelado')
            {
                $sSale = SSale::create([
                    'credit_id' => trim($row["idsolicitud"]), 
                    'client_name' => trim($row["nombre_del_cliente"]),
                    'credit_amount' => trim($row["montocredito"]),
                    'opening_amount' => trim($row["montoentregar"]),
                    'total_amount' => 0,
                    's_status_id' => $sStatus->id,
                    'grant_date' => $grant_date,
                    'institution_id' => $institution->id,
                    's_branch_id' => $sBranch->id,
                    's_credit_type_id' => $sCreditType->id,
                    's_promotor_id' => $promotor->id ?? null,
                    's_coordinator_id' => $coordinator->id ?? null
                ]);

                $commission = Commission::create([
                    
                ]);
            }
            // dd($sSale, $institution, $sBranch, $sStatus, $sCreditType, $coordinator, $promotor);
        }
    }
}