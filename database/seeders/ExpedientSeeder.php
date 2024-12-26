<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expedient;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;

use App\Models\Institution;
use App\Models\Anchorer;
use App\Models\ExpStatus;
use App\Models\UbiStatus;
use App\Models\Ubication;
use App\Models\ExpType;


class ExpedientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        // $this->addBaseExpedients("base_expedientes.xlsx");
        $this->addExpedients("abc19122024.xlsx");

    }

    public function addExpedients($file_name)
    {
        // Ruta al archivo Excel
        $file = base_path("resources/".$file_name);
        
        // Leer el archivo Excel y convertirlo en un array
        $pages = Excel::toArray(new ExcelImport(), $file);
        
        // Obtener todos los credit_id del nuevo archivo Excel
        $creditIdsFromExcel = [];
        foreach ($pages as $key => $page) {
            foreach ($page as $key => $sR) {
                if (trim($sR[0]) == "FIN") {
                    break;
                }
                if ($key > 0) {
                    $creditIdsFromExcel[] = trim($sR[0]); // Guardamos el credit_id
                }
            }
        }

        // Paso 1: Eliminar los expedientes que ya no están en el nuevo archivo Excel
        Expedient::whereNotIn('credit_id', $creditIdsFromExcel)
        ->update(["exp_status_id" => 2]);
        
        // Paso 2: Agregar los nuevos expedientes
        foreach ($pages as $key => $page) {
            foreach ($page as $key => $sR) {
                if (trim($sR[0]) == "FIN") {
                    break;
                }
                if ($key > 0) {
                    $institution = Institution::where("name", trim($sR[6]))->first();
                    if ($institution == null) {
                        $institution = Institution::create(["name" => trim($sR[6])]);
                    }

                    // Revisar si ya existe el expediente
                    $expedient = Expedient::where("credit_id", trim($sR[0]))->first();

                    // Si no existe agregarlo
                    if ($expedient == null) {
                        $anchorer = Anchorer::where("name", trim($sR[7]))->first();
                        $expType = ExpType::where("name", trim($sR[9]))->first();

                        // Convertir fechas
                        $f = ($sR[2] - 25569) * 86400;
                        $opening_date = date('Y-m-d', $f);

                        $f2 = ($sR[2] - 25569) * 86400;
                        $portafolio_date = date('Y-m-d', $f2);

                        // Crear el expediente
                        Expedient::create([
                            'credit_id' => trim($sR[0]),
                            'client_name' => trim($sR[1]),
                            'opening_date' => $opening_date,
                            'credit_amount' => trim($sR[3]),
                            'pay' => trim($sR[4]),
                            'portafolio_date' => $portafolio_date,
                            'institution_id' => $institution->id,
                            'anchorer_id' => $anchorer->id,
                            'exp_status_id' => 1, // Vigente o No vigente
                            'ubi_status_id' => $expType->id == 1 ? 3 : 1, // Safe data, no aplica, pendiente, resguardado
                            'ubication_id' => 2, // Valora o fimubac
                            'exp_type_id' => $expType->id, // Digital o autógrafa
                        ]);
                    }
                }
            }
        }
    }


    public function addBaseExpedients($file_name){
        $file = base_path("resources/".$file_name);
        $pages = (Excel::toArray(new ExcelImport(), $file));
        foreach ($pages as $key => $page) {
            foreach ($page as $key => $sR) {
                if (trim($sR[0]) == "FIN") {
                    break;
                }
                if ($key > 0) {
                    $institution = Institution::where("name", trim($sR[6]))->first();
                    if ($institution == null) {
                        $institution = Institution::create(["name" => trim($sR[6])]);
                    }

                    $anchorer = Anchorer::where("name", trim($sR[7]))->first();
                    $expStatus = ExpStatus::where("name", trim($sR[8]))->first();
                    $ubication = Ubication::where("name", trim($sR[9]))->first();
                    $expType = ExpType::where("name", trim($sR[10]))->first();
                    $ubiStatus = UbiStatus::where("name", trim($sR[11]))->first();

                    $f = ($sR[2] - 25569) * 86400; 
                    $opening_date = date('Y-m-d', $f); 

                    $f2 = ($sR[2] - 25569) * 86400; 
                    $portafolio_date = date('Y-m-d', $f2); 
    
                    Expedient::create([
                        'credit_id' => trim($sR[0]),
                        'client_name' => trim($sR[1]),
                        'opening_date' => $opening_date,
                        'credit_amount' => trim($sR[3]),
                        'pay' => trim($sR[4]),
                        'portafolio_date' => $portafolio_date,
                        'institution_id' => $institution->id,
                        'anchorer_id' => $anchorer->id ?? 1,
                        'exp_status_id' => $expStatus->id, //Vigente o No vigente
                        'ubi_status_id' => $ubiStatus->id, //Safe data, no aplica, pendiente y resguardado
                        'ubication_id' => $ubication->id, //Valora o fimubac
                        'exp_type_id' => $expType->id, //digital o autografa
                    ]);
                }
            }
        }
    }
    
}

