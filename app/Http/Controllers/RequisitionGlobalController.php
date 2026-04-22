<?php

namespace App\Http\Controllers;

use App\DataTables\RequisitionGlobalDataTable;
use App\Enums\RequisitionGlobalStatusEnum;
use App\Models\RequisitionGlobal;
use App\Models\RequisitionStatus;
use App\Models\Requisition;
use App\Models\Bank;
use App\Enums\RequisitionStatusEnum;
use App\Services\RequisitionGlobalService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RequisitionGlobalController extends Controller
{
    public function index(RequisitionGlobalDataTable $datatable) {
        $allowAdd = auth()->user()->hasPermissions('requisition_globals.create');
        return $datatable->render('requisition_globals.index', compact('allowAdd'));
    }
    
    public function create(){
        $standByStatus = RequisitionStatus::where('name', RequisitionStatusEnum::STAND_BY_TREASURY->value)->first();

        $requisitions = Requisition::whereHas('lastLog', function ($q) use ($standByStatus){
            $q->where('to_status_id', $standByStatus->id);
        })
        // ->where('requisition_global_id', null)
        ->get();

        return view('requisition_globals.create', compact('requisitions'));
    }

    public function store(Request $request){
        $service = new RequisitionGlobalService();
        list($status, $error, $globalRequisition) = $service->store($request);
        $message = "Requisición Global creada correctamente";

        if (!$status){
            try {
                $message = $this->getErrorMessage($error, 'requisition_globals');
            } catch (\Throwable $th) {
                $message = $error;
            }
        }

        return $this->getResponse($status, $message, $globalRequisition);
    }

    public function edit(RequisitionGlobal $requisition_global){
        $standByStatus = RequisitionStatus::where('name', RequisitionStatusEnum::STAND_BY_TREASURY->value)->first();

        $newReqs = Requisition::whereHas('lastLog', function ($q) use ($standByStatus){
            $q->where('to_status_id', $standByStatus->id);
        })
        ->get();

        $requisitions = $requisition_global->requisitions->merge($newReqs)->values();

        return view('requisition_globals.edit', compact('requisition_global', 'requisitions'));
    }

    public function update(Request $request, RequisitionGlobal $requisition_global){
        $service = new RequisitionGlobalService();
        list($status, $error) = $service->update($request, $requisition_global);
        $message = "Requisición Global editada correctamente";

        if (!$status){
            try {
                $message = $this->getErrorMessage($error, 'requisition_globals');
            } catch (\Throwable $th) {
                $message = $error;
            }
        }

        return $this->getResponse($status, $message);
    }

    public function show(RequisitionGlobal $requisition_global){
        $suppliersWithTotals = $requisition_global->suppliersWithTotals();
        $banks = Bank::where("is_active", 1)->pluck("name", "id");

        $isAbleToSend = auth()->user()->hasPermissions('requisition_globals.send');
        $statusName = $requisition_global->requisitionGlobalStatus->name;

        $isSendingToReview = $isAbleToSend && ($statusName == RequisitionGlobalStatusEnum::CREATED->value || $statusName == RequisitionGlobalStatusEnum::MODIFIED->value);
        $isSendingToDg = $isAbleToSend && $statusName == RequisitionGlobalStatusEnum::REVIEWED->value;

        $isEmpty = $requisition_global->requisitions->isEmpty();

        $isAbleToReturnBeforeCheck = true;

        return view('requisition_globals.show', compact('requisition_global', 'suppliersWithTotals', 'isSendingToReview', 'isSendingToDg', 'isAbleToReturnBeforeCheck', 'banks', 'isEmpty'));
    }

    public function exportPdf(Request $request, RequisitionGlobal $requisition_global) {
        //Toma una de las requisiciones de la global para obtener correctamente la firma de Administracion / Contabilidad
        //Evita tambien que hardcodeemos la firma de DG y Contabilidad
        $requisition = $requisition_global->requisitions[0]; 

        $pdf = Pdf::loadView('requisition_globals.pdf.layout', [
            'requisition_global' => $requisition_global,
            'requisition' => $requisition,
        ])->setPaper('letter', 'portrait');

        return $pdf->stream('requisition'.$requisition_global->id.'.pdf');
    }

    public function destroy(Request $request, RequisitionGlobal $requisition_global){
        $service = new RequisitionGlobalService();
        list($status, $error) = $service->destroy($request, $requisition_global);
        $message = "Requisición Global eliminada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisition_globals');
        }

        return $this->getResponse($status, $message);
    }

    public function send(Request $request, RequisitionGlobal $requisition_global){
        $service = new RequisitionGlobalService();
        list($status, $error) = $service->send($request, $requisition_global);
        $message = "Requisición Global enviada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisition_globals');
        }

        return $this->getResponse($status, $message);
    }

    public function return(Request $request, RequisitionGlobal $requisition_global){
        $service = new RequisitionGlobalService();
        list($status, $error) = $service->return($request, $requisition_global);
        $message = "Requisición Global devuelta correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisition_globals');
        }

        return $this->getResponse($status, $message);
    }

    public function changeStatus(Request $request, RequisitionGlobal $requisition_global){
        $suppliersWithTotals = $requisition_global->suppliersWithTotals();

        $service = new RequisitionGlobalService();
        $service->changeStatus($requisition_global);

        return view('requisition_globals.changeStatus', compact('requisition_global', 'suppliersWithTotals'));
    }

    public function updateStatus(Request $request, RequisitionGlobal $requisition_global){
        $service = new RequisitionGlobalService();
        list($status, $error) = $service->updateStatus($request, $requisition_global);        
        $message = "Requisición Global revisada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisition_globals');
        }

        return $this->getResponse($status, $message);
    }

    public function review(Request $request, RequisitionGlobal $requisition_global){
        $suppliersWithTotals = $requisition_global->suppliersWithTotals();

        $service = new RequisitionGlobalService();
        $service->review($requisition_global);

        return view('requisition_globals.dg.review', compact('requisition_global', 'suppliersWithTotals'));
    }
    public function approve(Request $request, RequisitionGlobal $requisition_global){
        $service = new RequisitionGlobalService();
        list($status, $error) = $service->approve($request, $requisition_global);   
        $message = "Requisición Global revisada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisition_globals');
        }

        return $this->getResponse($status, $message);
    }
}
