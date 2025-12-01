<?php

namespace App\Http\Controllers;

use App\DataTables\ContractsDataTable;
use App\Http\Requests\ContractRequest;
use App\Models\Contract;
use App\Models\ContractType;
use Illuminate\Database\QueryException;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function index(ContractsDataTable $dataTable){
        $allowAdd = auth()->user()->hasPermissions("users.create");
        return $dataTable->render('contracts.index', compact("allowAdd"));
    }

    public function create(){
        $types = ContractType::pluck('name', 'id');

        return view('contracts.create', compact( 'types'));
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

        return view('contracts.edit', compact('contract', 'types'));
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

    public function exportContract(Contract $contract){
        $pdf = PDF::loadView('contracts.pdf.userContract', [
            'contract' => $contract,
        ])->setPaper('letter', 'portrait');

        return $pdf->download('contract'.$contract->id.'.pdf');
    }
}
