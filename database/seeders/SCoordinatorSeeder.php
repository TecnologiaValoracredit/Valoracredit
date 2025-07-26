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
                $maternal_surname = "";
                if ($row[3] != "") {
                    $maternal_surname = $row[3]." ";
                }

               

                //Crear coordinador si no existe
                $sCoordinator = User::where("name", trim($row[20]))->where("role_id", 13)->first();
                if ($sCoordinator == null) {
                     $userC = User::create([
                        "name" => trim($row[20]),
                        "email" => 'user_' . Str::random(6) . '@example.com',
                        "password" => Hash::make("123456"),
                        "role_id" => 13, //Coordinador
                        "departament_id" => 8, //Comercial
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

                if ($row[3] != "") {
                    $maternal_surname = $row[3]." ";
                }
                $userP = User::create([
                    "name" => $row[1]." ".$row[2].$maternal_surname." ".$row[4],
                    "email" => 'user_' . Str::random(6) . '@example.com',
                    "password" => Hash::make("123456"),
                    "role_id" => 12, //Promotor
                    "departament_id" => 8, //Comercial
                    "branch_id" => 1
                ]);

                $sPromotor = SPromotor::create([
                    'user_id'=> $userP->id,
                    'commission_percentage'=> '0',
                    'coordinator_id' => User::where("name", trim($row[20]))->where("role_id", 13)->first()->coordinator->id,
                    's_branch_id'=> SBranch::where("name", trim($row[19]))->first()->id,
                    'promotor_credisoft_id' => $row[0]
                ]);
                

            }
        }

    }
}
