<?php

namespace App\Http\Controllers;

use App\Models\RequisitionRow;
use App\Models\RequisitionRowEvidence;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class RequisitionRowEvidenceController extends Controller
{
    public function index() {}
    public function create() {}
    public function store() {}
    public function edit() {}
    public function update() {}
    public function show() {}
    public function evidences(RequisitionRow $requisitionRow){
        $evidences = $requisitionRow->evidences;

        $paths = [];
        foreach ($evidences as $evidence) {
            $path = [
                'id' => $evidence->id,
                'path' => route('files.showPublic', $evidence->path),
            ];
            array_push($paths, $path);
        }

        return response()->json($paths);
    }

    public function destroy(RequisitionRowEvidence $requisitionRowEvidence){
        $status = true;
        $message = null;

        try {
            Storage::disk('public')->delete($requisitionRowEvidence->path);
            $requisitionRowEvidence->delete();

            $message = "Evidencia eliminada correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'requisition_row_evidences');
        }

        return $this->getResponse($status, $message);
    }
}
