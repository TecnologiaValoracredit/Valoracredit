<?php

namespace App\Http\Controllers;

use App\Models\FixedExpense;
use App\Services\FixedExpenseService;
use App\DataTables\FixedExpenseDataTable;
use Illuminate\Http\Request;

class FixedExpenseController extends Controller
{
    public function index(FixedExpenseDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("fixed_expenses.create");
        return $dataTable->render('fixed_expenses.index', compact('allowAdd'));
    }

    public function create() {
        return view('fixed_expenses.create');
    }

    public function store(Request $request) {
        $service = new FixedExpenseService();
        list($status, $error, $fixedExpense) = $service->store($request);
        $message = "Tipo de Gasto creado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'fixed_expenses');
        }

        return $this->getResponse($status, $message, $fixedExpense);
    }

    public function edit(FixedExpense $fixedExpense) {
        return view('fixed_expenses.edit', compact('fixedExpense'));
    }

    public function update(Request $request, FixedExpense $fixedExpense) {
        $service = new FixedExpenseService();
        list($status, $error, $fixedExpense) = $service->update($request, $fixedExpense);
        $message = "Tipo de Gasto actualizado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'fixed_expenses');
        }

        return $this->getResponse($status, $message, $fixedExpense);
    }

    public function show(FixedExpense $fixedExpense) {

    }

    public function destroy(FixedExpense $fixedExpense) {
        $service = new FixedExpenseService();
        list($status, $error) = $service->destroy($fixedExpense);
        $message = "Tipo de Gasto eliminado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'fixed_expenses');
        }

        return $this->getResponse($status, $message);
    }

    public function getFields(FixedExpense $fixedExpense){
        $req = $fixedExpense->requisition;

        if (is_null($req)){
            $message = "No existen los datos del Gasto Fijo solicitado";

            return abort(422, $message);
        }

        $reqObj = [
            "requisition" => $req,
            "requisition_rows" => $req->requisitionRows,
        ];

        return response()->json($reqObj);
    }
}
