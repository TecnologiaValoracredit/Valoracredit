<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\PaymentType;
use App\Models\Branch;
use App\Models\Departament;
use App\Models\Supplier;
use App\DataTables\RequisitionDataTable;
use App\Models\PermissionModule;
use App\DataTables\RequisitiontDataTable;
use App\Http\Requests\RequisitionRequest;


class RequisitionController extends Controller
{
    
    public function index(RequisitionDataTable $dataTable)
    {
        
        $allowAdd = auth()->user()->hasPermissions("requisitions.create");
        return $dataTable->render('requisitions.index', compact("allowAdd"));
    }

    public function create()
    {
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
         return view('requisitions.create', compact('departaments', 'payment_types', 'branches', 'suppliers'));
    }

    public function store(RequisitionRequest $request)
    {
        $status = true;
		$requisition = null;

        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$requisition = Requisition::create($params);
			$message = "Requisición creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'requisitions');
		}
        return $this->getResponse($status, $message, $requisition);

    }

    public function edit(Requisition $requisition)
    {
        return view('requisitions.edit', compact("requisition"));
    }

    public function update(RequisitionRequest $request, Requisition $requisition)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$requisition->update($params);
			$message = "Requisición modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'requisitions');
		}
        return $this->getResponse($status, $message, $requisition);

    }

    public function show(Requisition $requisition)
    {
        $modules = PermissionModule::all();
        return view("requisitions.show", compact("requisitions", "modules"));
    }

    public function destroy(Requisition $requisition)
    {
        $status = true;
        try {
            $requisition->update(["is_active" => false]);
            $message = "Requisición desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'requisitions');
        }
        return $this->getResponse($status, $message);
    }


}



