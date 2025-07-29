<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SCoordinator;
use App\Models\SPromotor;

use App\Models\User;
use App\Models\SBranch;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash; // Importar la fachada Hash

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;

class SCoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = base_path("resources/promotores_corregido.xlsx");
        $pages = Excel::toArray(new ExcelImport(), $file); 
        foreach($pages[0] as $key =>$row)
        {
            if ($key > 0) {

                //Crear coordinador si no existe
                $sCoordinator = User::where("name", trim($row[20]))->where("role_id", 20)->first();
                if ($sCoordinator == null) {
                     $userC = User::create([
                        "name" => trim($row[20]),
                        "email" => 'user_' . Str::random(6) . '@example.com',
                        "password" => Hash::make("123456"),
                        "role_id" => 20, //Coordinador
                        "departament_id" => 14, //Comercial
                        "branch_id" => 1
                    ]);

                    $sCoordinator = SCoordinator::create([
                        'user_id'=> $userC->id,
                        'commission_percentage'=> '0',
                        's_branch_id'=> SBranch::where("name", trim($row[19]))->first()->id,
                        'is_broker'=> false,
                    ]);
                }


                //Usuario para promotor
                $paternal = $row[3];
                if ($row[2] != "") { // Si tiene segundo nombre
                    $paternal = $row[2]." ".$row[3];
                }

                if ($row[1]." ".$paternal." ".$row[4] != $row[20]) {
                    $userP = User::create([
                        "name" => $row[1]." ".$paternal." ".$row[4],
                        "email" => 'user_' . Str::random(6) . '@example.com',
                        "password" => Hash::make("123456"),
                        "role_id" => 19, //Promotor
                        "departament_id" => 14, //Comercial
                        "branch_id" => 1
                    ]);

                    $sPromotor = SPromotor::create([
                        'user_id'=> $userP->id,
                        'commission_percentage'=> '0',
                        'coordinator_id' => User::where("name", trim($row[20]))->where("role_id", 20)->first()->coordinator->id,
                        's_branch_id'=> SBranch::where("name", trim($row[19]))->first()->id,
                        'promotor_credisoft_id' => $row[0]
                    ]);
                }else{
                    $userP = User::where("name", trim($row[20]))->first();
                    $sPromotor = SPromotor::create([
                        'user_id'=> $userP->id,
                        'commission_percentage'=> '0',
                        'coordinator_id' => User::where("name", trim($row[20]))->where("role_id", 20)->first()->coordinator->id,
                        's_branch_id'=> SBranch::where("name", trim($row[19]))->first()->id,
                        'promotor_credisoft_id' => $row[0]
                    ]);
                }
                
                

            }
        }

    }
}
