<?php

namespace App\Http\Controllers;

use App\DataTables\ContractTypeDataTable;
use App\Http\Requests\ContractTypeRequest;
use Illuminate\Http\Request;
use App\Models\ContractType;

use Illuminate\Database\QueryException;

class ContractTypeController extends Controller
{
    public function index(ContractTypeDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("contract_types.create");
        return $dataTable->render('contract_types.index', compact("allowAdd"));
    }
        
    public function create() {
        return view('contract_types.create');
    }

    public function store(ContractTypeRequest $request) {
        $status = true;
        $contractType = null;

        $params = array_merge($request->all(), [
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $contractType = ContractType::create($params);
            $message = "Tipo de contrato creado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'contract_types');
        }

        return $this->getResponse($status, $message, $contractType);
    }

    public function edit(ContractType $contractType) {
        return view('contract_types.edit', compact('contractType'));
    }

    public function update(ContractTypeRequest $request, ContractType $contractType) {
        $status = true;
        $message = null;

        $params = array_merge($request->all(), [
            'name' => $request->name,
            'description' => $request->description,
            'duration' => $request->duration,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $contractType->update($params);
            $message = "Tipo de contrato modificado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'contract_types');
        }

        return $this->getResponse($status, $message, $contractType);
    }

    public function show(ContractType $contractType) {}

    public function destroy(ContractType $contractType) {
        $status = true;
        $message = null;

        try {
            $contractType->update([
                'is_active' => 0,
            ]);
            $message = "Tipo de contrato desactivado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'contract_types');
        }

        return $this->getResponse($status, $message, $contractType);
    }
}
