<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\ExpenseDuration;
use App\Models\ExpenseType;
use App\Models\FixedExpense;
use App\Enums\RequisitionStatusEnum;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\PaymentType;
use App\Models\Branch;
use App\Models\Departament;
use App\Models\Supplier;
use App\Models\CurrencyType;
use App\Services\RequisitionService;
use App\DataTables\RequisitionDataTable;
use App\Http\Requests\RequisitionRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class RequisitionController extends Controller
{
    public function __construct(private RequisitionService $service) {}

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
        $expense_types = ExpenseType::where("is_active", 1)->pluck('name', 'id');
        $fixed_expenses = FixedExpense::where("created_by", auth()->id())->where('is_active', 1)->pluck('name', 'id');
        $expense_durations = ExpenseDuration::all()->pluck('name', 'id');

        return view('requisitions.create', compact('user','departaments', 'payment_types', 'branches', 'suppliers', 'currency_types', 'expense_types', 'fixed_expenses', 'expense_durations'));
    }

    public function store(Request $request)
    {
        list($status, $error, $requisition) = $this->service->store($request);
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
        $expense_types = ExpenseType::where("is_active", 1)->pluck('name', 'id');
        $expense_durations = ExpenseDuration::all()->pluck('name', 'id');

        $user = auth()->user();
        $boss = $user->boss ?? 1;

        $requisition_rows = $requisition->requisitionRows()->get();

        return view('requisitions.edit', compact('requisition', 'payment_types', 'branches', 'suppliers', 'currency_types', 'departaments', 'user', 'boss', 'requisition', 'requisition_rows', 'expense_types', 'banks', 'expense_durations'));
    }
    
    public function update(Request $request, Requisition $requisition)
    {
        list($status, $error, $requisition) = $this->service->update($request, $requisition);
        $message = "Requisición actualizada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message, $requisition);
    }

    public function destroy(Requisition $requisition)
    {
        list($status, $error) = $this->service->destroy($requisition);
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

        $banks = Bank::where("is_active", 1)->pluck("name", "id");

        return view('requisitions.payment', compact('requisition', 'currentOwnerPermission', 'banks'));
    }

    public function uploadPayment(Request $request, Requisition $requisition){
        list($status, $error) = $this->service->uploadPayment($request, $requisition);
        $message = "Comprobante de pago subido correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }

    public function send(Request $request, Requisition $requisition){
        list($status, $error) = $this->service->send($request, $requisition);
        $message = "Requisición enviada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }

    public function return(Request $request, Requisition $requisition){
        list($status, $error) = $this->service->return($request, $requisition);
        $message = "Requisición devuelta correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }
    public function cancel(Request $request, Requisition $requisition){
        list($status, $error) = $this->service->cancel($request, $requisition);
        $message = "Requisición cancelada correctamente";

        if (!$status){
            // $message = $this->getErrorMessage($error, 'requisitions');
            $message = $error;
        }

        return $this->getResponse($status, $message);
    }
    public function deny(Request $request, Requisition $requisition){
        list($status, $error) = $this->service->deny($request, $requisition);
        $message = "Requisición denegada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }

    public function chargePolicy(RequisitionRequest $request, Requisition $requisition){
        list($status, $error) = $this->service->chargePolicy($request, $requisition);
        $message = "Poliza cargada correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }

    public function updateBank(Request $request, Requisition $requisition){
        list($status, $error) = $this->service->updateBank($request, $requisition);
        $message = "Banco actualizado correctamente";

        if (!$status){
            $message = $this->getErrorMessage($error, 'requisitions');
        }

        return $this->getResponse($status, $message);
    }
}