<?php

namespace App\Http\Controllers;

use App\DataTables\VacationBalanceDataTable;
use App\Services\VacationBalanceService;
use Illuminate\Http\Request;

class VacationBalanceController extends Controller
{
    public function index(VacationBalanceDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("vacation_balances.create");
        return $dataTable->render('vacation_balances.index', compact('allowAdd'));
    }
    public function create() {
        return view('vacation_balances.create');
    }
    public function store(Request $request) {
        $service = new VacationBalanceService();
        list($status, $error, $vacationBalance) = $service->store($request);
        $message = "Balance de vacaciones creado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacation_balances');
        }

        return $this->getResponse($status, $message, $vacationBalance);
    }
    public function edit() {
        return view('vacation_balances.edit');
    }
    public function update() {

    }
    public function show() {
        return view('vacation_balances.show');
    }
    public function destroy() {

    }
}
