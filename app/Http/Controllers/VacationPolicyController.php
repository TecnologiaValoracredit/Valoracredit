<?php

namespace App\Http\Controllers;

use App\DataTables\VacationPolicyDataTable;
use Illuminate\Http\Request;
use App\Services\VacationBalanceService;

class VacationPolicyController extends Controller
{
    public function index(VacationPolicyDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("vacation_policies.create");
        return $dataTable->render('vacation_policies.index', compact('allowAdd'));
    }
    public function create() {
        return view('vacation_policies.create');
    }
    public function store() {

    }
    public function edit() {
        return view('vacation_policies.edit');
    }
    public function update() {

    }
    public function show() {
        return view('vacation_policies.show');
    }
    public function destroy() {

    }
}
