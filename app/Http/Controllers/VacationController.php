<?php

namespace App\Http\Controllers;

use App\DataTables\VacationDataTable;
use Illuminate\Http\Request;

class VacationController extends Controller
{
    public function index(VacationDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("vacations.create");
        return $dataTable->render('vacations.index', compact('allowAdd'));
    }
    public function create() {
        return view('vacations.create');
    }
    public function store() {

    }
    public function edit() {
        return view('vacations.edit');
    }
    public function update() {

    }
    public function show() {
        return view('vacations.show');
    }
    public function destroy() {

    }
}
