<?php

namespace App\Http\Controllers;

use App\Models\VacationPolicy;
use App\DataTables\VacationPolicyDataTable;
use Illuminate\Http\Request;
use App\Services\VacationPolicyService;

class VacationPolicyController extends Controller
{
    public function __construct(private VacationPolicyService $service) { }
    public function index(VacationPolicyDataTable $dataTable) {
        $allowAdd = auth()->user()->hasPermissions("vacation_policies.create");
        return $dataTable->render('vacation_policies.index', compact('allowAdd'));
    }
    public function create() {
        return view('vacation_policies.create');
    }
    public function store(Request $request) {
        list($status, $error) = $this->service->store($request);
        $message = "Política creada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacation_policies');
        }

        return $this->getResponse($status, $message);
    }
    public function edit(VacationPolicy $vacationPolicy) {
        return view('vacation_policies.edit', compact('vacationPolicy'));
    }
    public function update(Request $request, VacationPolicy $vacationPolicy) {
        list($status, $error) = $this->service->update($request, $vacationPolicy);
        $message = "Política modificada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacation_policies');
        }

        return $this->getResponse($status, $message);
    }
    public function show() {
        return view('vacation_policies.show');
    }
    public function destroy(VacationPolicy $vacationPolicy) {
        list($status, $error) = $this->service->destroy($vacationPolicy);
        $message = "Política eliminada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacation_policies');
        }

        return $this->getResponse($status, $message);
    }
}
