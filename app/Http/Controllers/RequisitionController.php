<?php

namespace App\Http\Controllers;

use App\DataTables\RequisitionRowsDataTable;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\PaymentType;
use App\Models\Branch;
use App\Models\User;
use App\Models\Departament;
use App\Models\Supplier;
use App\DataTables\RequisitionDataTable;
use App\Models\PermissionModule;
use App\Models\RequisitionRow;
use App\Models\RequisitionRowOptional;
use Illuminate\Support\Facades\Auth; 
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
        $user = auth()->user();
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $suppliers = Supplier::all();

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

        return view('requisitions.create', compact('departaments', 'payment_types', 'branches', 'suppliers', 'user', 'requisitionRowsDT'));
    }

    public function store(Request $request)
    {
        // Convertir 'is_active' a valor booleano (1 o 0)
        $is_active = $request->input('is_active') === 'on' ? 1 : 0;
    
        dd($request);
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
    
        // Validar y procesar las filas del arreglo "rows" (fila inicial)
        if ($request->has('rows')) {
            $request->validate([
                'rows.*.supplier_id' => 'required|exists:suppliers,id',
                'rows.*.description' => 'required|string',
                'rows.*.unit_price' => 'required|numeric',
                'rows.*.amount' => 'required|numeric',
                'rows.*.url' => 'required|url',
                'rows.*.include_iva' => 'nullable|boolean',
            ]);
    
            foreach ($request->rows as $row) {
                // Si no viene incluido, asignamos 0 por defecto
                $includeIva = isset($row['include_iva']) ? $row['include_iva'] : 0;
    
                RequisitionRow::create([
                    'product' => $row['product'],
                    'product_description' => $row['description'],
                    'product_quantity' => $row['amount'],
                    'product_cost' => $row['unit_price'],
                    'has_iva' => $includeIva,
                    'total_cost' => 0,
                    'reason',
                    'evidence',
                    'link'  => $row['url'],
                    'requisition_id',
                    'parent_id',
                    'supplier_id' => $row['supplier_id'],
                    'is_active' => true,
                    'created_by'=> auth()->id(), 
                    'updated_by' => auth()->id(),
                    'requisition_id' => $requisition->id,
                ]);
            }
        }
    
        // Validar y procesar las filas opcionales del arreglo "requisition_row_optional"
        if ($request->has('requisition_row_optional')) {
            $request->validate([
                'requisition_row_optional.*.supplier_id' => 'required|exists:suppliers,id',
                'requisition_row_optional.*.description' => 'required|string',
                'requisition_row_optional.*.unit_price' => 'required|numeric',
                'requisition_row_optional.*.amount' => 'required|numeric',
                'requisition_row_optional.*.url' => 'required|url',
                'requisition_row_optional.*.include_iva' => 'required|boolean',
            ]);
    
            foreach ($request->requisition_row_optional as $optionalRow) {
                RequisitionRowOptional::create([
                    'requisition_id' => $requisition->id,
                    'supplier_id'    => $optionalRow['supplier_id'],
                    'description'    => $optionalRow['description'],
                    'unit_price'     => $optionalRow['unit_price'],
                    'amount'         => $optionalRow['amount'],
                    'subtotal'       => $optionalRow['subtotal'] ?? 0,
                    'include_iva'    => $optionalRow['include_iva'],
                    'url'            => $optionalRow['url'],
                ]);
            }
        }
    
        return redirect()->route('requisitions.index')->with('success', 'Requisición creada correctamente');
    }
    
    
    
    public function edit($id)
    {
        $requisition = Requisition::findOrFail($id);
        $payment_types = PaymentType::all()->pluck('name', 'id'); // Cambia 'name' y 'id' según los campos de tu modelo PaymentType
        $branches = Branch::all(); // Asegúrate de cargar también las sucursales
        $suppliers = Supplier::all(); // Y los proveedores si es necesario
    
        return view('requisitions.edit', compact('requisition', 'payment_types', 'branches', 'suppliers'));
    }
    


    
    public function update(Request $request, Requisition $requisition)
    {
        // VALIDAR LOS CAMPOS DEL FORMULARIO
        $validated = $request->validate([
            'payment_type_id' => 'required',
            'branch_id' => 'required',
            'requisition_row' => 'required|array|min:1',
            'requisition_row.*.supplier_id' => 'required|exists:suppliers,id',
            'requisition_row.*.amount' => 'required|numeric|min:1',
            'requisition_row.*.unit_price' => 'required|numeric|min:0',
            'requisition_row.*.description' => 'required|string',
            'requisition_row.*.url' => 'required|url',
            'requisition_row.*.include_iva' => 'nullable',
    
            'requisition_row_optional' => 'nullable|array',
            'requisition_row_optional.*.id' => 'nullable|exists:requisition_row_optionals,id', // Para identificar las filas existentes
            'requisition_row_optional.*.supplier_id' => 'required|exists:suppliers,id',
            'requisition_row_optional.*.amount' => 'required|numeric|min:1',
            'requisition_row_optional.*.unit_price' => 'required|numeric|min:0',
            'requisition_row_optional.*.description' => 'required|string',
            'requisition_row_optional.*.url' => 'required|url',
            'requisition_row_optional.*.include_iva' => 'nullable',
        ]);
    
        // ACTUALIZAR CAMPOS DE LA REQUISICIÓN
        $requisition->update([
            'payment_type_id' => $validated['payment_type_id'],
            'branch_id' => $validated['branch_id'],
        ]);
    
        // PROCESAR FILAS PRINCIPALES
        $existingRows = $requisition->requisitionRows()->pluck('id')->toArray();
        $sentRowIds = [];
    
        foreach ($validated['requisition_row'] as $rowData) {
            $rowData['subtotal'] = round($rowData['amount'] * $rowData['unit_price'], 2);
            if (!empty($rowData['include_iva'])) {
                $rowData['subtotal'] *= 1.16;
            }
    
            if (!empty($rowData['id'])) {
                // ACTUALIZAR FILA EXISTENTE
                $row = RequisitionRow::find($rowData['id']);
                if ($row) {
                    $row->update($rowData);
                    $sentRowIds[] = $rowData['id'];
                }
            } else {
                // CREAR NUEVA FILA
                $rowData['requisition_id'] = $requisition->id;
                $newRow = RequisitionRow::create($rowData);
                $sentRowIds[] = $newRow->id;
            }
        }
    
        // ELIMINAR FILAS QUE YA NO ESTÁN PRESENTES
        $rowsToDelete = array_diff($existingRows, $sentRowIds);
        RequisitionRow::whereIn('id', $rowsToDelete)->delete();
    
        // PROCESAR FILAS OPCIONALES
        $existingOptionalRows = $requisition->requisitionRowOptional()->pluck('id')->toArray();
        $sentOptionalRowIds = [];
    
        if (isset($validated['requisition_row_optional'])) {
            foreach ($validated['requisition_row_optional'] as $optionalRowData) {
                $optionalRowData['subtotal'] = round($optionalRowData['amount'] * $optionalRowData['unit_price'], 2);
                if (!empty($optionalRowData['include_iva'])) {
                    $optionalRowData['subtotal'] *= 1.16;
                }
    
                if (!empty($optionalRowData['id'])) {
                    // ACTUALIZAR FILA OPCIONAL EXISTENTE
                    $optionalRow = RequisitionRowOptional::find($optionalRowData['id']);
                    if ($optionalRow) {
                        $optionalRow->update($optionalRowData);
                        $sentOptionalRowIds[] = $optionalRowData['id'];
                    }
                } else {
                    // CREAR NUEVA FILA OPCIONAL
                    $optionalRowData['requisition_id'] = $requisition->id;
                    $newOptionalRow = RequisitionRowOptional::create($optionalRowData);
                    $sentOptionalRowIds[] = $newOptionalRow->id;
                }
            }
        }
    
        // ELIMINAR FILAS OPCIONALES QUE YA NO ESTÁN PRESENTES
        $optionalRowsToDelete = array_diff($existingOptionalRows, $sentOptionalRowIds);
        RequisitionRowOptional::whereIn('id', $optionalRowsToDelete)->delete();
    
        return redirect()->route('requisitions.index')->with('success', 'Requisición actualizada exitosamente');
    }
    

    public function getTotalAttribute()
{
    $total = 0;

    // Sumar subtotales de filas principales
    foreach ($this->requisitionRows as $row) {
        $total += $row->subtotal;
    }

    // Sumar subtotales de filas opcionales
    foreach ($this->requisitionRowOptional as $optionalRow) {
        $total += $optionalRow->subtotal;
    }

    return round($total, 2);
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





    public function show($id)
    {
        // Cargar la requisición con sus relaciones necesarias:
        // - 'departament' para el departamento  
        // - 'branch' para la sucursal  
        // - 'requisitionRows.supplier' para la(s) fila(s) principal(es) con su proveedor  
        // - 'requisitionRowOptionals.supplier' para las filas opcionales con su proveedor
        $requisition = Requisition::with([
            'departament',
            'branch',
            'requisitionRows.supplier',
            'requisitionRowOptionals.supplier'
        ])->findOrFail($id);
    
        // Para la sección "Producto" principal se utiliza la primera fila de requisición
        $requisition_row = $requisition->requisitionRows->first();
    
        // Retornamos la vista 'requisitions.show' pasando las variables necesarias
        return view('requisitions.show', compact('requisition', 'requisition_row'));
    }
    
    

    

}



