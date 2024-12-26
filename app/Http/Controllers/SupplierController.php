<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\PermissionModule;
use App\DataTables\SupplierDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public function index(SupplierDataTable $dataTable)
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("suppliers.create");
        return $dataTable->render('suppliers.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(SupplierRequest $request)
    {
        $status = true;
		$supplier = null;

        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$supplier = Supplier::create($params);
			$message = "Proveedor creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'suppliers');
		}
        return $this->getResponse($status, $message, $supplier);

    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact("supplier"));
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$supplier->update($params);
			$message = "Proveedor modificado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'suppliers');
		}
        return $this->getResponse($status, $message, $supplier);

    }

    public function show(Supplier $supplier)
    {
        $modules = PermissionModule::all();
        return view("suppliers.show", compact("supplier", "modules"));
    }

    public function destroy(Supplier $supplier)
    {
        $status = true;
        try {
            $supplier->update(["is_active" => false]);
            $message = "Proveedor desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'suppliers');
        }
        return $this->getResponse($status, $message);
    }


}

