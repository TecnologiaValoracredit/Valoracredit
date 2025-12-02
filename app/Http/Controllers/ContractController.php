<?php

namespace App\Http\Controllers;

use App\DataTables\ContractsDataTable;
use App\Http\Requests\ContractRequest;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\ContractVariable;
use App\Models\User;

use Illuminate\Database\QueryException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function index(ContractsDataTable $dataTable){
        $allowAdd = auth()->user()->hasPermissions("users.create");
        return $dataTable->render('contracts.index', compact("allowAdd"));
    }

    public function create(){
        $types = ContractType::pluck('name', 'id');
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
        $types = ContractType::pluck('name', 'id');
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
                'file_path' => $path,
            ]);

            return response()->download(storage_path("app/{$path}"));
        }

       
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
                    $handler = new $var->handler();
                    $value = $handler($modelInstance);
                    break;
            }

            $contractContent = str_replace($var->key_detection, $value, $contractContent);
        }

        return $contractContent;
    }

}
