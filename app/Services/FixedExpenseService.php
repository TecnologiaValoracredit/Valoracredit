<?php

namespace App\Services;

use App\Models\FixedExpense;
use App\Models\Requisition;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FixedExpenseService
{
    public function __construct()
    {
        
    }
   
    public function store(Request $request){
        $status = true;
        $error = null;
        $fixedExpense = null;
        
        $req = Requisition::where('id', $request->input('req-id'))->first();
        $params = array_merge($request->all(), [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
            'requisition_id' => $req->id,
            'created_by' => auth()->id(),
        ]);

        try {
            $fixedExpense = FixedExpense::create($params);

            $req->update([
                'is_fixed' => true,
            ]);
        } catch (QueryException $e) {
            $status = false;    
            $error = $e;
        }

        return [$status, $error, $fixedExpense];
    }

    public function update(Request $request, FixedExpense $fixedExpense){
        $status = true;
        $error = null;

        $req = Requisition::where('id', $request->input('req-id'))->first();
        $params = array_merge($request->all(), [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $fixedExpense->update($params);

            if ($req){
                //Quita la requisición anterior como gasto fijo
                $fixedExpense->requisition->update([
                    'is_fixed' => false,
                ]);
                //Actualiza la requisición referenciada con la nueva seleccionada
                $fixedExpense->update([
                    'requisition_id' => $req->id,
                ]);
            }
        } catch (QueryException $e) {
            $status = false;    
            $error = $e;
        }

        return [$status, $error, $fixedExpense];
    }

    public function destroy(FixedExpense $fixedExpense){
        $status = true;
        $error = null;

        try {
            $fixedExpense->update([
                'is_active' => false,
            ]);

            $req = $fixedExpense->requisition;
            $req->update([
                'is_fixed' => false,
            ]);
        } catch (QueryException $e) {
            $status = false;    
            $error = $e;
        }

        return [$status, $error];
    }
}
