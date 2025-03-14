<?php



namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;

use Illuminate\Http\Request;
use App\Models\FFlux;
use App\Models\FMovementType;
use App\Models\FAccount;
use App\Models\FStatus;
use App\Models\FCarteraStatus;
use App\Models\FBeneficiary;
use App\Models\FClasification;
use App\Models\FCobClasification;
use App\Models\SCreditType;
use App\Models\SSale;

use App\Models\PermissionModule;
use App\DataTables\FFluxDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FFluxRequest;

use Carbon\Carbon;

class FFluxController extends Controller
{
    public function index(FFluxDataTable $dataTable )
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("f_fluxes.create");
        $f_statuses = FStatus::where("is_active", 1)->pluck("name", "id");
        $f_cartera_statuses = FCarteraStatus::where("is_active", 1)->pluck("name", "id");

        $f_beneficiaries = FBeneficiary::where("is_active", 1)->pluck("name", "id");
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");

        $f_clasifications = FClasification::where("is_active", 1)
        ->whereNotNull("parent_id")
        ->pluck("name", "id")
        ->prepend("Sin clasificar", -1);
        
        $f_cob_clasifications = FCobClasification::where("is_active", 1)
        ->pluck("name", "id")
        ->prepend("Sin clasificar", -1);

        $f_accounts = FAccount::where("is_active", 1)->pluck("name", "id");

        return $dataTable->render('f_fluxes.index', compact("allowAdd", "f_cartera_statuses", "f_accounts","f_movement_types","f_statuses","f_beneficiaries", "f_clasifications", "f_cob_clasifications"));
    }

    public function create()
    {
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");
        $f_accounts = FAccount::where("is_active", 1)->pluck("name", "id");
        $f_statuses = FStatus::where("is_active", 1)->pluck("name", "id");
        $f_clasifications = FClasification::where("is_active", 1)
        ->whereNotNull("parent_id")
        ->selectRaw('
            CASE 
                WHEN description IS NOT NULL AND description != "" 
                THEN CONCAT(name, " - ", description) 
                ELSE name 
            END as name_description, id
        ')->pluck('name_description', 'id');
        $f_cob_clasifications = FCobClasification::where("is_active", 1)->pluck("name", "id");

        return view('f_fluxes.create', compact("f_movement_types", "f_accounts", "f_statuses", "f_clasifications", "f_cob_clasifications"));
    }

    public function createFromExcel()
    {
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");
        $f_accounts = FAccount::where("is_active", 1)->pluck("name", "id");
        $f_statuses = FStatus::where("is_active", 1)->pluck("name", "id");
        $f_clasifications = FClasification::where("is_active", 1)
        ->whereNotNull("parent_id")
        ->selectRaw('
            CASE 
                WHEN description IS NOT NULL AND description != "" 
                THEN CONCAT(name, " - ", description) 
                ELSE name 
            END as name_description, id
        ')->pluck('name_description', 'id');
        $f_cob_clasifications = FCobClasification::where("is_active", 1)->pluck("name", "id");

        $allowAddBeneficiaries = auth()->user()->hasPermissions("f_beneficiaries.store");

        return view('f_fluxes.createFromExcel', compact("f_movement_types", "f_accounts", "f_statuses", "f_clasifications", "f_cob_clasifications", "allowAddBeneficiaries"));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);
        $f_accounts = FAccount::where("is_active", 1)->get();
        $f_movement_types = FMovementType::where("is_active", 1)->get();

        $data = Excel::toArray(new ExcelImport(), $request->file('file'))[0];
        $columnCount = count($data[0]); // Contar columnas en la primera fila
        
        if ($columnCount == 12) {
            $finalRows = $this->readStpExcel($data);
        }else if ($columnCount == 20) {
            $finalRows = $this->readOtherBanksExcel($data);
        }

        return view('f_fluxes.table-excel', compact('f_accounts', 'f_movement_types'), ['rows' => $finalRows])->render();
    }

    private function readStpExcel($rows)
    {
        $f_beneficiary = FBeneficiary::find(1); //Este es el ID beneficiario de deposito a cliente
        $finalRows = [];
        //Quitar las primeras 31 rows que no nos sirven
        $rows = array_slice($rows, 32);
        foreach ($rows as $key => $row) {
            //Cortar el ciclo cuando encuentre uno vacío
            if ($row[2] == null || $row[2] == "") {
                break;
            }
            $fechaFormateada = Carbon::createFromFormat('d/m/Y h:i:s a', $row[2])->format('Y-m-d');

            //Verificar el tipo de movimiento
            $f_movement_type_id = 1; //Ingreso default
            $amount = $row[8];
            if ($row[7] > 0) {
                $amount = $row[7];
                $f_movement_type_id = 2;
            }

            
            //ESTO ES PARA SACAR LA CLASIFICACIÓN
            $concept = trim($row[4]); // Extraer el texto
            // Buscar un número al inicio del texto
            preg_match('/^\d+/', $concept, $match);
            $numero = isset($match[0]) ? (int) $match[0] : null;
            
            
            // Si no hay número, evita la consulta
            if ($numero !== null) {
                $sale = SSale::where("credit_id", $numero)->first();
                $f_clasification = null;
                if ($sale->s_credit_type_id == 1) {
                    $f_clasification = FClasification::where("name", "Dispersiones")->first();
                }else if ($sale->s_credit_type_id == 2) {
                    $f_clasification = FClasification::where("name", "Reestructura de Clientes")->first();
                }

            } else {
                $f_clasification = FClasification::where("name", "WS PROMOTORA - I")->first();
            }

            $tracking_key = trim($row[5]);
            if ($tracking_key == null) {
                $tracking_key = Carbon::createFromFormat('d/m/Y h:i:s a', $row[2])->format('YmdHis');
                $tracking_key .= $row[9];
            }

            //Verificar si ya existe ese row en el flujo
            $f_flux = FFlux::where("tracking_key", $tracking_key)->first();
            if ($f_flux == null) {
                $finalRows[] = [
                    "accredit_date" => $fechaFormateada,
                    "f_beneficiary_id" => $f_beneficiary->id,
                    "f_beneficiary_name" => $f_beneficiary->name,
                    "concept" => trim($row[4]),
                    "f_account_id" => 5, //La 5 es STP
                    "f_movement_type_id" => $f_movement_type_id,
                    "f_clasification_id" => $f_clasification->id ?? null,
                    "f_clasification_name" => $f_clasification->name ?? null,
                    "tracking_key" => trim($row[5]),
                    "amount" => $amount
                ];
            }
        }
        return $finalRows; 
    }
    private function readOtherBanksExcel($rows)
    {
        $finalRows = [];
        //Quitar las primeras 31 rows que no nos sirven
        $rows = array_slice($rows, 1);
        foreach ($rows as $key => $row) {
            //Cortar el ciclo cuando encuentre uno vacío
            if ($row[2] == null || $row[2] == "") {
                break;
            }
            $fecha = trim($row[1], "'");
            $fechaFormateada = Carbon::createFromFormat('dmY', $fecha)->format('Y-m-d');

            //Verificar el tipo de movimiento
            $f_movement_type_id = 1; //Ingreso default
            $amount = $row[6];
            if ($row[5] == "-") {
                $f_movement_type_id = 2;
            }

            $concept = $row[9]; 
            // Eliminar espacios extra dejando solo un espacio entre palabras
            $concept = preg_replace('/\s+/', ' ', trim($concept));
            
            if ($concept == "" || $concept == null) {
                $concept = preg_replace('/\s+/', ' ', trim($row[4]));
            }

            $f_beneficiary = FBeneficiary::where("name", trim($row[12]))->first(); //Este es el ID beneficiario de deposito a cliente

            $account = FAccount::where("account_number", trim($row[0], "'"))->first();

            $tracking_key = trim($row[19]);
            if ($tracking_key == null) {
                $tracking_key = $fecha;
                $tracking_key .= trim($row[3], "'");
                $tracking_key .= $this->getInitials($row[4]);
                $tracking_key .= $row[6].$row[7];
            }

            //Verificar si ya existe ese row en el flujo
            $f_flux = FFlux::where("tracking_key", $tracking_key)->first();

            if ($f_flux == null) {
                $finalRows[] = [
                "accredit_date" => $fechaFormateada,
                "f_beneficiary_id" => $f_beneficiary->id ?? null,
                "f_beneficiary_name" => $f_beneficiary->name ?? trim($row[12]),
                "concept" => $concept,
                "f_account_id" => $account->id ?? null,
                "f_movement_type_id" => $f_movement_type_id,
                "f_clasification_id" => null,
                "f_clasification_name" => null,
                "tracking_key" => $tracking_key,
                "amount" => $amount
            ];
            }
        }
        return $finalRows; 
    }

    function getInitials($text) {
        // Eliminar espacios extra
        $text = trim(preg_replace('/\s+/', ' ', $text));
    
        // Dividir en palabras por espacio
        $words = explode(' ', $text);
    
        // Obtener la primera letra de cada palabra
        $initials = array_map(fn($word) => substr($word, 0, 1), $words);
    
        // Unir las initials en un string
        return implode('', $initials);
    }

    public function store(FFluxRequest $request)
    {
        $status = true;
		$f_flux = null;
        $params = array_merge($request->all(), [
            'f_status_id' => 1,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$f_flux = FFlux::create($params);
			$message = "Flujo creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_fluxes');
		}
        return $this->getResponse($status, $message, $f_flux);

    }

    public function storeFromExcel(Request $request)
    {
        $status = true;
		$datos = $request->except('_token'); 

        $registros = [];
        foreach ($datos['tracking_key'] as $i => $trackingKey) {
            $registros[] = [
                'tracking_key' => $trackingKey,
                'accredit_date' => $datos['accredit_date'][$i],
                'f_beneficiary_id' => $datos['f_beneficiary_id'][$i],
                'f_clasification_id' => $datos['f_clasification_id'][$i],
                'f_account_id' => $datos['f_account_id'][$i],
                'f_movement_type_id' => $datos['f_movement_type_id'][$i],
                'amount' => $datos['amount'][$i],
                'concept' => $datos['concept'][$i],
                'notes1' => $datos['notes1'][$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

		try {
            FFlux::insert($registros);
			$message = "Flujo creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_fluxes');
		}
        return $this->getResponse($status, $message);

    }

    public function edit(FFlux $f_flux)
    {
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");
        $f_accounts = FAccount::where("is_active", 1)->pluck("name", "id");
        $f_statuses = FStatus::where("is_active", 1)->pluck("name", "id");
        $f_clasifications = FClasification::where("is_active", 1)
        ->whereNotNull("parent_id")
        ->selectRaw('
            CASE 
                WHEN description IS NOT NULL AND description != "" 
                THEN CONCAT(name, " - ", description) 
                ELSE name 
            END as name_description, id
        ')->pluck('name_description', 'id');
        $f_cob_clasifications = FCobClasification::where("is_active", 1)->pluck("name", "id");

        return view('f_fluxes.edit', compact("f_movement_types", "f_accounts", "f_statuses","f_flux", "f_clasifications", "f_cob_clasifications"));
     
    }

    public function update(FFluxRequest $request, FFlux $f_flux)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'is_active' => !is_null($request->is_active),
		]);

		try {
            $f_flux->update($params);
			$message = "Flujo modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_fluxes');
		}
        return $this->getResponse($status, $message, $f_flux);

    }

    public function show(FFlux $f_flux)
    {
    }

    public function destroy(FFlux $f_flux)
    {
        $status = true;
        try {
            $f_flux->update(["is_active" => false]);
            $message = "Flujo desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_fluxes');
        }
        return $this->getResponse($status, $message);
    }

    public function changeStats(FFlux $f_flux)
    {
        $status = true;
        try {
            $f_flux->update(["f_status_id" => 2]);
            $message = "Estatus cambiado  correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_fluxes');
        }
        return $this->getResponse($status, $message);
    }

    public function changeCarteraStatus(FFlux $f_flux)
    {
        $status = true;
        try {
            $f_flux->update(["f_cartera_status_id" => 2]);
            $message = "Estatus cambiado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_fluxes');
        }
        return $this->getResponse($status, $message);
    }

    public function showExpenses(FFlux $f_movement_types)
    {
        $allowAdd = auth()->user()->hasPermissions("f_fluxes.showExpenses");

        $f_movement_types = FMovementType::where("is_active",1)->where("id",1)->pluck("name","id");

        return $dataTable->render('f_fluxes.index', compact("allowAdd", "f_movement_types", "f_statuses", "f_beneficiaries"));
    }

    

    public function showIncome(FFlux $f_movement_types)
    {
        $allowAdd = auth()->user()->hasPermissions("f_fluxes.showIncome");

        $f_movement_types = FMovementType::where("is_active",0)->where("id",1)->pluck("name","id");
        
        return $dataTable->render('f_fluxes.index', compact("allowAdd","f_movement_types","f_statuses","f_beneficiaries"));
    }

    


}

