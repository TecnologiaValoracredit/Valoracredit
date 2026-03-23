<?php

namespace App\Services;

use App\Models\RequisitionRow;
use App\Models\RequisitionRowEvidence;
use Illuminate\Database\QueryException;

class RequisitionRowService
{
    protected $evidences;

    public function __construct(RequisitionRow $requisition_row)
    {
        $this->evidences = $requisition_row->evidences;
    }

    public function deleteEvidences()
    {
        $result = true;
        $message = null;

        try {            
            foreach ($this->evidences as $evidence){
                $evidence->delete();
            }
        } catch (QueryException $e) {
            $result = false;
            $message ="requisition_row_evidences error: {$e}";
        }

        return [$result, $message];
    }
}