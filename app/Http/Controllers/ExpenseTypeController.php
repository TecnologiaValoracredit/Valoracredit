<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseTypeDataTable;
use App\Models\ExpenseType;
use App\Services\ExpenseTypeService;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index(ExpenseTypeDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("expense_types.create");
        return $dataTable->render('expense_types.index', compact('allowAdd'));
    }

    public function create() {
        return view('expense_types.create');
    }

    public function store(Request $request) {
        $service = new ExpenseTypeService();
        list($status, $error, $expenseType) = $service->store($request);
        $message = "Tipo de Gasto creado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'fixed_expenses');
        }

        return $this->getResponse($status, $message, $expenseType);
    }

    public function edit(ExpenseType $expenseType) {
        return view('expense_types.edit', compact('expenseType'));
    }

    public function update(Request $request, ExpenseType $expenseType) {
        $service = new ExpenseTypeService();
        list($status, $error, $expenseType) = $service->update($request, $expenseType);
        $message = "Tipo de Gasto actualizado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'fixed_expenses');
        }

        return $this->getResponse($status, $message, $expenseType);
    }

    public function show(ExpenseType $expenseType) {

    }

    public function destroy(ExpenseType $expenseType) {
        $service = new ExpenseTypeService();
        list($status, $error) = $service->destroy($expenseType);
        $message = "Tipo de Gasto eliminado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'fixed_expenses');
        }

        return $this->getResponse($status, $message);
    }
}
