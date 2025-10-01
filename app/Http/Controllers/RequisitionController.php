<?php

namespace App\Http\Controllers;

use App\DataTables\RequisitionRowsDataTable;
use App\Exports\RequisitionRequestExport;
use App\Models\RequisitionResponse;
use App\Models\RequisitionStatus;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\PaymentType;
use App\Models\Branch;
use App\Models\User;
use App\Models\Departament;
use App\Models\Supplier;
use App\Models\CurrencyType;
use App\DataTables\RequisitionDataTable;
use App\Models\PermissionModule;
use App\Models\RequisitionRow;
use App\Models\RequisitionRowOptional;
use Illuminate\Support\Facades\Auth; 
use App\Http\Requests\RequisitionRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;



class RequisitionController extends Controller
{
    
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

        $user = auth()->user();
        $boss = $user->boss ?? 1;
        $admonF = User::where('email', 'admonfinanzas@valoracredit.mx')->first();
        $chief = User::where('email', 'berlangahector@hotmail.com')->first();
        $requisition = Requisition::create([
            'user_id' => $user->id,
            'requisition_status_id' => 1,
            'payment_type_id' => 1,
            'amount' => 0,
            'request_date' => now(),
            'departament_id' => $user->departament->id,
            'branch_id' =>  $user->branch->id,
            'approval_boss_id' => $boss->id ?? 1,
            'approval_admin_id'=> $admonF->id,
            'approval_chief_id' => $chief->id,
            'is_active'  => true,
            'created_by' => auth()->id(), 
            'updated_by'=> auth()->id(),
        ]);

        $requisitionRowsDataTable = new RequisitionRowsDataTable($requisition);
        $params = ['requisition' => $requisition];
        $requisitionRowsDT = $this->getViewDataTable($requisitionRowsDataTable, 'requisition_rows', [], 'requisition_rows.getRequisitionRowsDataTable', $params);

        return view('requisitions.create', compact('departaments', 'payment_types', 'branches', 'suppliers', 'currency_types', 'user', 'requisition', 'requisitionRowsDT'));
    }

    public function store(Request $request)
    {
        // Convertir 'is_active' a valor booleano (1 o 0)
        $is_active = $request->input('is_active') === 'on' ? 1 : 0;
    
        // dd($request);
        // Crear la requisición principal
        $user = User::where('id', $request->input('user_id'))->first();
        $boss = $user->boss;
        $admonF = User::where('email', 'admonfinanzas@valoracredit.mx')->first();
        $chief = User::where('email', 'berlangahector@hotmail.com')->first();
        $requisition = Requisition::create([
            'user_id' => $user->id,
            'requisition_status_id' => 1,
            'payment_type_id' => $request->input('payment_type_id'),
            'amount' => 0,
            'request_date' => $request->input('request_date', now()),
            'departament_id' => $request->input('departament_id'),
            'branch_id' =>  $request->input('branch_id'),
            'approval_boss_id' => $boss->id,
            'approval_admin_id'=> $admonF->id,
            'approval_chief_id' => $chief->id,
            'is_active'  => $is_active,
            'created_by' => auth()->id(), 
            'updated_by'=> auth()->id(),
        ]);
    
        return redirect()->route('requisitions.index')->with('success', 'Requisición creada correctamente');
    }
    
    
    
    public function edit(Requisition $requisition)
    {
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");

        $user = auth()->user();
        $boss = $user->boss ?? 1;

        $requisitionRowsDataTable = new RequisitionRowsDataTable($requisition);
        $params = ['requisition' => $requisition];
        $requisitionRowsDT = $this->getViewDataTable($requisitionRowsDataTable, 'requisition_rows', [], 'requisition_rows.getRequisitionRowsDataTable', $params);

        return view('requisitions.edit', compact('requisition', 'payment_types', 'branches', 'suppliers', 'currency_types', 'departaments', 'user', 'boss', 'requisition', 'requisitionRowsDT'));
    }
    
    public function update(Request $request, Requisition $requisition)
    {
        $status = true;
        
        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
            'update_at' => now(),
            'update_by' => auth()->user()
		]);
        try {
			$requisition->update($params);
			$message = "Requisición modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'requisition');
		}

         return $this->getResponse($status, $message, $requisition);
    }    

    public function destroy($id)
    {
        $optionalRow = RequisitionRowOptional::find($id);
        if (!$optionalRow) {
            return response()->json(['error' => 'Fila opcional no encontrada'], 404);
        }

        $optionalRow->delete();

        return response()->json(['success' => 'Fila opcional eliminada correctamente']);
    }

    public function show(Requisition $requisition)
    {
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        

        $requisitionRowsDataTable = new RequisitionRowsDataTable($requisition, null, true);
        $params = ['requisition' => $requisition, 'requisitionRow' => null, 'is_show' => true];
        $requisitionRowsDT = $this->getViewDataTable($requisitionRowsDataTable, 'requisition_rows', [], 'requisition_rows.getRequisitionRowsDataTable', $params);

        // Retornamos la vista 'requisitions.show' pasando las variables necesarias
        return view('requisitions.show', compact('requisition', 'payment_types', 'departaments', 'branches', 'requisitionRowsDT'));
    }
    
    
    public function exportReport(Requisition $requisition) {
        $pdf = Pdf::loadView('requisitions.pdf.requisitionRequest', [
            'requisition' => $requisition
        ])->setPaper('letter', 'portrait');

        return $pdf->download('requisition'.$requisition->id.'.pdf');
    }
    
    public function changeStatus(Requisition $requisition,  $requisition_status){
        $message = "";
        $requisition_status = RequisitionStatus::findOrFail($requisition_status);
        $user = auth()->user();
        try {
            $requistion_response = RequisitionResponse::create([
                "requisition_id" => $requisition->id,
                "requisition_status_id" => $requisition_status->id,
                "reason" => "example",
                "user_id" => $user->id,
                "created_at" => now(),
                "updated_at" => now(),
                "created_by" => $user->id,
                "updated_by" => $user->id,

            ]);
			$requisition->requisition_status_id = $requisition_status->id;
            $requisition->save();
			$message = "Requisición modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'requisition');
		}
    }

}



