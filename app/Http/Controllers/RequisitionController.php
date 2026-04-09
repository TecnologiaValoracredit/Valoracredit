<?php

namespace App\Http\Controllers;

use App\DataTables\RequisitionRowsDataTable;
use App\Enums\RequisitionOwnerPermissionEnum;
use App\Exports\RequisitionRequestExport;
use App\Models\Bank;
use App\Models\ExpenseDuration;
use App\Models\ExpenseType;
use App\Models\FixedExpense;
use App\Models\RequisitionMonthRegistry;
use App\Models\RequisitionResponse;
use App\Models\RequisitionStatus;
use App\Enums\RequisitionStatusEnum;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\PaymentType;
use App\Models\Branch;
use App\Models\User;
use App\Models\Departament;
use App\Models\Supplier;
use App\Models\CurrencyType;
use App\Services\RequisitionService;
use App\DataTables\RequisitionDataTable;
use App\Models\PermissionModule;
use App\Models\RequisitionRow;
use App\Models\RequisitionRowEvidence;
use App\Models\RequisitionLog;
use App\Models\RequisitionRowOptional;
use Illuminate\Support\Facades\Auth; 
use App\Http\Requests\RequisitionRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequisitionMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Webklex\PDFMerger\PDFMerger;
use Illuminate\Filesystem\Filesystem;

class RequisitionController extends Controller
{
    //BASE CRUD
    
    public function index(RequisitionDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("requisitions.create");
        return $dataTable->render('requisitions.index', compact("allowAdd"));
    }

    public function create()
    {
        $user = auth()->user();
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");
        $expense_types = ExpenseType::all()->pluck('name', 'id');
        $fixed_expenses = FixedExpense::all()->pluck('name', 'id');
        $expense_durations = ExpenseDuration::all()->pluck('name', 'id');

        return view('requisitions.create', compact('user','departaments', 'payment_types', 'branches', 'suppliers', 'currency_types', 'expense_types', 'fixed_expenses', 'expense_durations'));
    }

    public function store(Request $request)
    {
        $service = new RequisitionService();
        list($status, $error, $requisition) = $service->store($request);
        $message = "Requisición creada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message, $requisition);
    }
    
    public function edit(Requisition $requisition)
    {
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");
        $banks = Bank::where("is_active", 1)->pluck("name", "id");
        $expense_types = ExpenseType::all()->pluck('name', 'id');
        $expense_durations = ExpenseDuration::all()->pluck('name', 'id');

        $user = auth()->user();
        $boss = $user->boss ?? 1;

        $requisition_rows = $requisition->requisitionRows()->get();

        return view('requisitions.edit', compact('requisition', 'payment_types', 'branches', 'suppliers', 'currency_types', 'departaments', 'user', 'boss', 'requisition', 'requisition_rows', 'expense_types', 'banks', 'expense_durations'));
    }
    
    public function update(Request $request, Requisition $requisition)
    {
        $service = new RequisitionService();
        list($status, $error, $requisition) = $service->update($request, $requisition);
        $message = "Requisición actualizada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message, $requisition);
    }

    public function destroy(Requisition $requisition)
    {
        $service = new RequisitionService();
        list($status, $error) = $service->destroy($requisition);
        $message = "Requisición enviada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }

    public function show(Requisition $requisition)
    {
        $lastStatus = $requisition->lastLog->toStatusId->name;
        $isAbleToSendAndDelete = $lastStatus == RequisitionStatusEnum::CREATED->value;
        $isAbleToSendAndCancel = $lastStatus == RequisitionStatusEnum::RETURNED_BY_BOSS->value || $lastStatus == RequisitionStatusEnum::RETURNED_BY_TREASURY->value;

        return view('requisitions.show', compact('requisition', 'isAbleToSendAndDelete', 'isAbleToSendAndCancel'));
    }
      
    public function exportPdf(Request $request, Requisition $requisition) {
        $hasNotes = false; 
        $notes = "";

        if ($requisition->lastLog->notes){
            $hasNotes = true;
            $notes = $requisition->lastLog->notes;
        }

        $pdf = Pdf::loadView('requisitions.pdf.layout', [
            'requisition' => $requisition,
            'notes' => $notes,
            'hasNotes' => $hasNotes,
        ])->setPaper('letter', 'portrait');


        return $pdf->stream('requisition'.$requisition->id.'.pdf');
    }

    //FLUX  -
    
    public function changeStatus(Request $request, Requisition $requisition){
        $currentOwnerPermission = $requisition->current_owner_permission;
        $isBossAndCreator = $requisition->boss->id == auth()->id() && $requisition->user->id == auth()->id();

        return view('requisitions.changeStatus', compact('requisition', 'currentOwnerPermission', 'isBossAndCreator'));
    }
    
    public function payment(Request $request, Requisition $requisition){
        $currentOwnerPermission = $requisition->current_owner_permission;

        return view('requisitions.payment', compact('requisition', 'currentOwnerPermission'));
    }

    public function uploadPayment(Request $request, Requisition $requisition){
        $service = new RequisitionService();
        list($status, $error) = $service->uploadPayment($request, $requisition);
        $message = "Comprobante de pago subido correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }

    public function send(Request $request, Requisition $requisition){
        $service = new RequisitionService();
        list($status, $error) = $service->send($request, $requisition);
        $message = "Requisición enviada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }

    public function return(Request $request, Requisition $requisition){
        $service = new RequisitionService();
        list($status, $error) = $service->return($request, $requisition);
        $message = "Requisición devuelta correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }
    public function cancel(Request $request, Requisition $requisition){
        $service = new RequisitionService();
        list($status, $error) = $service->cancel($request, $requisition);
        $message = "Requisición cancelada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }
    public function deny(Request $request, Requisition $requisition){
        $service = new RequisitionService();
        list($status, $error) = $service->deny($request, $requisition);
        $message = "Requisición denegada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }
    public function approve(Request $request, Requisition $requisition){
        //AUN NO IMPLEMENTADO EL APROBAR UNA REQUISICION INDIVIDUAL, PERO ESTE SERIA EL METODO
    
        dd('Aprobar');
    }

    public function chargePolicy(RequisitionRequest $request, Requisition $requisition){
        $service = new RequisitionService();
        list($status, $error) = $service->chargePolicy($request, $requisition);
        $message = "Poliza cargada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }
}