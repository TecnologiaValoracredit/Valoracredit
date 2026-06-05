<?php

namespace App\Http\Controllers;

use App\DataTables\VacationBalanceDataTable;
use App\Models\VacationBalance;
use App\Services\VacationBalanceService;
use Illuminate\Http\Request;

class VacationBalanceController extends Controller
{
    public function __construct(private VacationBalanceService $service) {}
    public function index(VacationBalanceDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("vacation_balances.create");
        return $dataTable->render('vacation_balances.index', compact('allowAdd'));
    }
    public function create() {
        return view('vacation_balances.create');
    }
    public function store(Request $request) {
        list($status, $error, $vacationBalance) = $this->service->store($request);
        $message = "Balance de vacaciones creado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacation_balances');
        }

        return $this->getResponse($status, $message, $vacationBalance);
    }
    public function edit(VacationBalance $vacationBalance) {
        return view('vacation_balances.edit', compact('vacationBalance'));
    }
    public function update(Request $request, VacationBalance $vacationBalance) {
        list($status, $error) = $this->service->update($request, $vacationBalance);
        $message = "Balance modificado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacation_balances');
        }

        return $this->getResponse($status, $message);
    }
    public function show() {
        return view('vacation_balances.show');
    }
    public function destroy() {

    }
}
