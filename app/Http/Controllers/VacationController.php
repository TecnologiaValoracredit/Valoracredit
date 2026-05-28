<?php

namespace App\Http\Controllers;

use App\DataTables\VacationDataTable;
use App\Models\User;
use App\Models\Vacation;
use App\Services\VacationService;
use Illuminate\Http\Request;

class VacationController extends Controller
{

    public function __construct(private VacationService $service) {}

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
        list($status, $error, $vacation) = $this->service->store($request);
        $message = "Vacaciones creadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message, $vacation);
    }

    public function edit(Vacation $vacation) {
        return view('vacations.edit', compact('vacation'));
    }

    public function update(Request $request, Vacation $vacation) {
        list($status, $error) = $this->service->update($request, $vacation);
        $message = "Vacaciones modificadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message);
    }

    public function show(Vacation $vacation) {
        $canAction = $this->service->canAction($vacation);
        $canSend = $this->service->canSend($vacation);
        $canDestroy = $this->service->canDestroy($vacation);

        return view('vacations.show', compact('vacation', 'canAction', 'canSend', 'canDestroy'));
    }

    public function destroy(Vacation $vacation) {
        list($status, $error) = $this->service->destroy($vacation);
        $message = "Vacaciones eliminadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message);
    }
    public function send(Request $request, Vacation $vacation) {
        list($status, $error) = $this->service->send($request, $vacation);
        $message = "Vacaciones enviadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message);
    }
    public function changeStatus(Request $request, Vacation $vacation) {
        $isHrOrHasPermissions = $this->service->isHrOrHasPermissions();
        $isBoss = $this->service->isBoss($vacation);

        $approveAs = $isHrOrHasPermissions && $isBoss ? "Aprobar como RH y Jefe Inmediato" : 
        ($isHrOrHasPermissions ? "Aprobar como RH" : 
        ($isBoss ? "Aprobar como Jefe Inmediato" : "No especificado"));

        return view('vacations.changeStatus', compact('vacation', 'approveAs'));
    }
    public function approve(Request $request, Vacation $vacation) {
        list($status, $error) = $this->service->approve($request, $vacation);
        $message = "Vacaciones aprobadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message);
    }
    public function deny(Request $request, Vacation $vacation) {
        list($status, $error) = $this->service->deny($request, $vacation);
        $message = "Vacaciones enviadas correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'vacations');
        }

        return $this->getResponse($status, $message);
    }
    public function exportPdf(Request $request, Vacation $vacation) {

    }
}
