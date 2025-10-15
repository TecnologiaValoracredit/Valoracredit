<?php

namespace App\Http\Controllers;

use App\DataTables\RequisitionRowsDataTable;
use App\DataTables\RequisitionOptionRowsDataTable;
use App\Http\Requests\RequisitionRowsRequest;
use App\Models\RequisitionRow;
use App\Models\Requisition;
use App\Models\Supplier;
use App\Models\CurrencyType;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequisitionRowsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequisitionRowsRequest $request)
    {
        $status = true;
        $requisitionRow = null;
        // dd($request);
        try {

            if($request->file('evidence')){
                $file = $request->file('evidence');
                $fileName = time() . '_' . $file->getClientOriginalName();
                /** @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
                $fileSystem = Storage::disk('public');
                $fileSystem->putFileAs('requisitions', $file, $fileName);
            }else{
                throw new \Exception("El archivo de evidencia es obligatorio.");
            }

            $params = array_merge($request->all(), [
                'evidence' =>  $fileName,
                'total_cost' => $request->total_cost,
                'product' => $request->product,
                'product_description' => $request->product_description,
                'product_quantity'=> $request->product_quantity,
                'product_cost' => $request->product_cost,
                'reason' => $request->reason,
                'has_iva' => !is_null($request->has_iva),
                'link' => $request->link,
                'requisition_id' => $request->requisition_id,
                'parent_id' => $request->parent_id ?? null,
                'created_by' =>  auth()->id(),
                'updated_by' =>  auth()->id(),
                'created_at' => date("Y-m-d H:i:s"),
			    'updated_at' => date("Y-m-d H:i:s")
            ]);
            // dd($params);

            $requisitionRow = RequisitionRow::create($params);

            // dd($requisitionRow);
            
            $message = "Fila de requisición creado correctamente";
            // dd($requisitionRow);

            // dd($user, $s_coordinator, $message);

        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'requisition_rows');
        }
        return $this->getResponse($status, $message, $requisitionRow);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $requisitionRow = RequisitionRow::findOrFail($id);
        $suppliers = Supplier::all(); // lo necesitas porque tu blade lo usa

        return view('requisition_rows.fields', compact('requisitionRow', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequisitionRowsRequest $request, RequisitionRow $requisition_row)
    {
        $status = true;
        $evidence = $requisition_row->evidence;

		try {
            if($request->file('evidence')){
                $file = $request->file('evidence');
                $fileName = time() . '_' . $file->getClientOriginalName();
                /** @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
                $fileSystem = Storage::disk('public');
                $fileSystem->putFileAs('requisitions', $file, $fileName);

                $evidence = $fileName;
            }
           

            $params = array_merge($request->all(), [
                'evidence' =>  $evidence,
                'total_cost' => $request->total_cost,
                'product' => $request->product,
                'product_description' => $request->product_description,
                'product_quantity'=> $request->product_quantity,
                'product_cost' => $request->product_cost,
                'reason' => $request->reason,
                'has_iva' => !is_null($request->has_iva),
                'link' => $request->link ?? null,
                'updated_by' =>  auth()->id(),
			    'updated_at' => date("Y-m-d H:i:s")
            ]);
			$requisition_row->update($params);
			$message = "Detalle de requisición modificado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'requisition_rows');
		}
        return $this->getResponse($status, $message, $requisition_row);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequisitionRow $requisition_row)
    {
            $status = true;
        try{
            $requisition_row->delete();
            $message = "Fila de requisición eliminada correctamente";
        }catch(\Illuminate\Database\QueryException $e){
            $status = false;
            $message = $this->getErrorMessage($e, 'requisition_rows');
        }

        return $this->getResponse($status, $message);
    }

    public function createModal(Request $request)
    {
        $req_id = $request->requisition_id; 
        $requisition = Requisition::find($req_id);
                // $row = RequisitionRow::findOrFail($id); // Trae el registro
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");

        // $requisitionRowsDataTable = new RequisitionOptionRowsDataTable($requisition, $row);
        // $params = ['requisition' => $requisition];
        // $requisitionRowChildDT = $this->getViewDataTable($requisitionRowsDataTable, 'requisition_rows', [], 'requisition_rows.getRequisitionRowsDataTable', $params);

        return response()->json([
            'html' => view('requisition_rows.modal_add', compact('requisition', 'suppliers', 'currency_types'))->render()
        ]);
    }

    public function editModal($id = null)
    {
        $requisitionRow = $id ? RequisitionRow::findOrFail($id) : null;
        $requisition = $id ? $requisitionRow->requisition : null;
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");

        return response()->json([
            'html' => view('requisition_rows.modal_add', compact('requisitionRow','requisition','suppliers', 'currency_types'))->render()
        ]);
    }

    public function showModal($id = null)
    {
        $requisitionRow = $id ? RequisitionRow::findOrFail($id) : null;
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");
        $readonly = true; 

        return response()->json([
            'html' => view('requisition_rows.modal_add', compact('requisitionRow','suppliers', 'currency_types', 'readonly'))->render()
        ]);
    }
    public function getRequisitionRowsDataTable(Requisition $requisition, RequisitionRow $requisition_row = null)
    {
        return (new RequisitionRowsDataTable($requisition, $requisition_row))->render('components.datatable');
    }

    public function getRequisitionOptionRowsDataTable(Requisition $requisition, RequisitionRow $requisition_row = null)
    {
        return (new RequisitionOptionRowsDataTable($requisition, $requisition_row))->render('components.datatable');
    }

    public function getFile(RequisitionRow $requisition_row) {
		return Storage::get("public/requisitions/" . $requisition_row->evidence);
	}

    public function downloadFile(RequisitionRow $requisition_row){
        return Storage::download("public/requisitions/" . $requisition_row->evidence, $requisition_row->evidence);
    }
}
