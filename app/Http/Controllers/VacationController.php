<?php

namespace App\Http\Controllers;

use App\DataTables\VacationDataTable;
use App\Models\User;
use App\Services\VacationService;
use Illuminate\Http\Request;

class VacationController extends Controller
{
    public function index(VacationDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("vacations.create");
        return $dataTable->render('vacations.index', compact('allowAdd'));
    }
    public function create() {
        $hrUser = User::whereHas('role', function($query) {
            $query->where('name', 'Recursos Humanos');
        })
        ->where('is_active', true)
        ->first();
        
        return view('vacations.create', compact('hrUser'));
    }
    public function store(Request $request) {
        $service = new VacationService();
        list($status, $error, $vacation) = $service->store($request);
        $message = "Vacaciones creadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message, $vacation);
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
    public function send(Request $request) {
        $service = new VacationService();
        list($status, $error) = $service->send($request);
        $message = "Vacaciones enviadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message);
    }
    public function approve(Request $request) {
        $service = new VacationService();
        list($status, $error) = $service->approve($request);
        $message = "Vacaciones enviadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message);
    }
    public function deny(Request $request) {
        $service = new VacationService();
        list($status, $error) = $service->deny($request);
        $message = "Vacaciones enviadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message);
    }
    public function exportPdf(Request $request) {
        
    }
}
