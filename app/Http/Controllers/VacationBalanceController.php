<?php

namespace App\Http\Controllers;

use App\DataTables\VacationBalanceDataTable;
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
    public function store() {

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
