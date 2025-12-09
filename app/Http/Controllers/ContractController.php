<?php

namespace App\Http\Controllers;

use App\DataTables\ContractsDataTable;
use App\Http\Requests\ContractRequest;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\ContractVariable;
use App\Models\User;
use App\Models\UserContract;
use Illuminate\Http\Request;

use Illuminate\Database\QueryException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index(ContractsDataTable $dataTable){
        $allowAdd = auth()->user()->hasPermissions("users.create");
        return $dataTable->render('contracts.index', compact("allowAdd"));
    }

    public function create(){
        $types = ContractType::select(
            'id',
            DB::raw("
                CONCAT(
                    name, 
                    ' - ',
                    CASE 
                        WHEN duration = -1 THEN 'Indeterminado'
                        ELSE CONCAT(duration, ' días')
                    END
                ) AS full_name
            ")
        )
        ->pluck('full_name', 'id');



        $variables = ContractVariable::all();
        return view('contracts.create', compact( 'types', 'variables'));
    }

    public function store(ContractRequest $request){
        $status = true;
        $contract = null;

        $params = array_merge($request->all(), [
            'name' => $request->name,
            'contract_type_id' => $request->contract_type_id,
            'content' => $request->content,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $contract = Contract::create($params);
            $message = "Contrato creado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'contracts');
        }

        return $this->getResponse($status, $message, $contract);
    }

    public function edit(Contract $contract){
       $types = ContractType::select(
            'id',
            DB::raw("
                CONCAT(
                    name, 
                    ' - ',
                    CASE 
                        WHEN duration = -1 THEN 'Indeterminado'
                        ELSE CONCAT(duration, ' días')
                    END
                ) AS full_name
            ")
        )
        ->pluck('full_name', 'id');


        $variables = ContractVariable::all();

        return view('contracts.edit', compact('contract', 'types', 'variables'));
    }

    public function update(ContractRequest $request, Contract $contract){
        $status = true;
        $message = null;

        $params = array_merge($request->all(), [
            'name' => $request->name,
            'contract_type_id' => $request->contract_type_id,
            'content' => $request->content,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $contract->update($params);
            $message = "Contrato modificado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'contracts');
        }

        return $this->getResponse($status, $message, $contract);
    }

    public function show(){

    }

    public function destroy(Contract $contract){
        $status = true;
        $message = null;

        try {
            $contract->update([
                'is_active' => 0,
            ]);
            $message = "Contrato desactivado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'contracts');
        }

        return $this->getResponse($status, $message, $contract);
    }

    public function exportContract(Contract $contract, $modelId = null){
        $content = $contract->content;
        
        if ($modelId == null) { //Si es para ver el preview en el la vista de contrato, sin vincular al usuario
            $content = $contract->content;
            $pdf = Pdf::loadView('contracts.pdf.userContract', [
                'content' => $content
            ]);

            return $pdf->stream('Contrato.pdf');
        }else{
            $initial_date = Carbon::parse(request()->initial_date);
            $duration = $contract->contractType->duration; // o del tipo de contrato

            if ($duration == -1) {
                // 99 años desde la fecha inicial
                $final_date = $initial_date->copy()->addYears(99);
            } else {
                $final_date = $initial_date->copy()->addDays($duration);
            }

            $user = User::findOrFail($modelId);
            $content = $this->processContract($content, $user);

             $pdf = Pdf::loadView('contracts.pdf.userContract', [
                'content' => $content
            ]);

            // 3. Nombrar archivo
            $fileName = 'Contrato-'.$contract->name.'-' . now()->format('YmdHis') . '.pdf';

            // 4. Ruta donde se guardará
            $path = "contracts/{$user->id}/" . $fileName;

            // 5. Guardar en storage/app/contracts/{userId}/
            Storage::disk('local')->put($path, $pdf->output());

            $user->contracts()->create([
                'contract_id' => $contract->id,
                'path_contract' => $path,
                'initial_date' => $initial_date,
                'final_date' => $final_date
            ]);

            return response()->json([
                "message" => "Contrato generado correctamente",
                "status" =>true,
                "user" => $user,
                "table" => $this->getTableContractUser($user)
            ]);
        }
    }

    //El type es signed o unsigned
    public function downloadContract(UserContract $user_contract, $type)
    {
        if ($type == "unsigned") {
            $path = $user_contract->path_contract;
        }else{
            $path = $user_contract->path_contract_signed;
        }
        $mimeType = Storage::disk('local')->mimeType($path);
        $fileContent = Storage::disk('local')->get($path);

        // Devolver la respuesta con el contenido del archivo y los encabezados adecuados
        return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="'.basename($path).'"');
    }

     //El type es signed o unsigned
    public function deleteContract(UserContract $user_contract)
    {
        $user = $user_contract->user;
        $user_contract->delete();
        return response()->json([
            "message" => "Contrato eliminado correctamente",
            "status" =>true,
            "user" => $user,
            "table" => $this->getTableContractUser($user)
        ]);
    }

    public function addUserContractSigned(UserContract $user_contract, Request $request)
    {
        $status = false;
        $file = $request->file("contract_signed");
        $message = "No se cargó el comprobante de pago";
        if ($file) {
            $user = $user_contract->user;
            $contract = $user_contract->contract;

            // 3. Nombrar archivo
            $fileName = 'Contrato firmado-'.$contract->name.'-' . now()->format('YmdHis') . '.pdf';

            // 4. Ruta donde se guardará
            $path = "contracts/{$user->id}/" . $fileName;

            Storage::disk('local')->putFileAs("contracts/{$user->id}", $file, $fileName);
            $params['path_contract_signed'] = $path;

            try {
                $user_contract->update($params);
                $message = "Contrato firmado cargado correctamente";
                $status = true;
            } catch (\Illuminate\Database\QueryException $e) {
                $status = false;
                $message = "Algo salió mal ". $e->getMessage();
            }
        }
       
        return response()->json([
            "message" => $message,
            "status" => $status,
            "user" => $user,
            "table" => $this->getTableContractUser($user)
        ]);
    }

    private function getTableContractUser(User $user)
    {
        return view("users.contracts-table", compact("user"))->render();
    }


    public function processContract($contractContent, $modelInstance)
    {
        $variables = ContractVariable::all();

        foreach ($variables as $var) {

            switch ($var->type) {

                case 'column':
                    $value = data_get($modelInstance, $var->model_column);
                    break;

                case 'relation':
                    $value = data_get($modelInstance, "{$var->relation_name}.{$var->relation_column}");
                    break;

                case 'custom':
                    $handler = $var->handler;
                    // Obtener el valor del column por si el handler lo necesita
                    $rawValue = data_get($modelInstance, $var->model_column);

                    // Llamada correcta al handler
                    $value = $handler::handle($rawValue, $modelInstance);
            }

            // Aplicar formato si existe
            if (!empty($var->format)) {
                $value = $this->applyFormat($value, $var->format);
            }

            $contractContent = str_replace($var->key_detection, $value, $contractContent);
        }

        return $contractContent;
    }

    private function applyFormat($value, $format)
    {
        if (!$value) {
            return $value;
        }

        switch ($format) {

            case 'date':
                // 2025-02-05 → 05/02/2025
                return \Carbon\Carbon::parse($value)->format('d/m/Y');

            case 'datetime':
                // 2025-02-05 → 05/02/2025
                return \Carbon\Carbon::parse($value)->format('d/m/Y H:i');

            case 'date_long':
                // 2025-02-05 → 5 de febrero de 2025
                return \Carbon\Carbon::parse($value)
                    ->locale('es')
                    ->isoFormat('D [de] MMMM [de] YYYY');

            case 'money':
                // 12345.5 → $12,345.50
                return number_format((float)$value, 2, '.', ',');

            case 'integer':
                // 12345.56 → 12,346
                return number_format((float)$value);

            case 'uppercase':
                return mb_strtoupper($value, 'UTF-8');

            case 'lowercase':
                return mb_strtolower($value, 'UTF-8');

            case 'capitalize':
                return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');

            default:
                return $value;
        }
    }

}
