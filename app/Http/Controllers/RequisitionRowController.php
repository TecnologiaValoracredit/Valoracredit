<?php

namespace App\Http\Controllers;

use App\Services\RequisitionRowService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\RequisitionRow;

class RequisitionRowController extends Controller
{
    public function index() {}
    public function create() {}
    public function store() {}
    public function edit() {}
    public function update() {}
    public function show() {}
    public function destroy(Request $request, RequisitionRow $requisition_row) {
        dd($request);
        $status = true;
        $message = null;

        $service = new RequisitionRowService($requisition_row);
        list($result, $resultMessage) = $service->deleteEvidences();

        if ($result){
            try {
                $requisition_row->delete();

                $message = "Producto de requisición eliminado correctamente";
            } catch (QueryException $e) {
                $status = false;
                $message = $this->getErrorMessage($e, 'requisition_rows');
            }
        }
        else{
            $status = false;
            $message = $resultMessage;
        }

        return $this->getResponse($status, $message);
    }
}
