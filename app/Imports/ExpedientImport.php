<?php

namespace App\Imports;

use App\Models\Expedient;
use App\Models\Institution;
use App\Models\Anchorer;
use App\Models\ExpType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExpedientImport implements ToCollection,
WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Expedient|null
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            // dd($row);
            //Obtenemos el id del credito
            $creditId = trim($row["id_creditoifnb"]);

            //Se debe comprobar que el estatus sea "Vigente" y el fondeador esté en la base de datos

            //Se obtiene el status 
            $status = trim($row["estatus"]);
            //Se obtiene el fondeador
            $anchorer = trim($row["fondeador"]);
            //Comprobamos que el fondeador esté en la base de datos
            $anchorerExists = Anchorer::where("name", $anchorer)->exists();
            //Obtenemos el expediente
            $expedient = Expedient::where("credit_id", $creditId)->first();

            //Si es vigente y existe el fondeador
            if( $status == "Vigente" && $anchorerExists ) {
                //Si no existe el expediente valido, se crea, en cambio, si existe el expediente valido no se hace nada
                if(!$expedient){
                    $clientName = trim($row["nombre_del_acreditado"]);

                    //Formatea la fecha
                    $openingDate = trim($row["fecha_de_apertura_de_credito"]);
                    $openingDate = ($openingDate - 25569) * 86400;
                    $openingDate = date('Y-m-d', $openingDate);

                    $creditAmount = trim($row['importe_del_credito']);

                    $pay = trim($row['pago']);

                    //Formatea la fecha
                    $portafolioDate = trim($row['fecha_de_registro_en_portafolio']);
                    $portafolioDate = ($portafolioDate - 25569) * 86400;
                    $portafolioDate = date('Y-m-d', $portafolioDate);

                    //Busca la institucion en la base de datos
                    $institution = Institution::where("name", trim($row["institucion"]))->first();
                    //Si no existe la institucion, la crea
                    if ($institution == null) {
                        $institution = Institution::create(["name" => trim($row["institucion"])]);
                    }

                    $anchorer = Anchorer::where("name", $anchorer)->first();
                    $expType = ExpType::where("name", trim($row["estatusfirmadigital"]))->first();

                    //Se crea el expediente
                    Expedient::create([
                        'credit_id' => $creditId,
                        'client_name' => $clientName,
                        'opening_date' => $openingDate,
                        'credit_amount' => $creditAmount,
                        'pay' => $pay,
                        'portafolio_date' => $portafolioDate,
                        'institution_id' => $institution->id,
                        'anchorer_id' => $anchorer->id,
                        'exp_status_id' => 1, // Vigente o No vigente
                        'ubi_status_id' => $expType->id == 1 ? 3 : 1, // Safe data, no aplica, pendiente, resguardado
                        'ubication_id' => 2, // Valora o fimubac
                        'exp_type_id' => $expType->id, // Digital o autógrafa
                        'created_by'=> auth()->id(),
                    ]);
                }
            //Si el expediente es invalido y existe en la base de datos
            }elseif($expedient){
                //Cambiamos su estatus a no vigente
                $expedient->exp_status_id = 2;
            }
        }
    }
    
    
}