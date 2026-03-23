<?php

namespace App\Services;

use App\Models\ExpenseType;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Exceptions\WhatsAppException;
use Illuminate\Http\Request;

class ExpenseTypeService
{
    public function __construct()
    {

    }
   
    public function store(Request $request){
        $status = true;
        $error = null;
        $expenseType = null;

        $params = array_merge($request->all(), [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $expenseType = ExpenseType::create($params);
        } catch (QueryException $e) {
            $status = false;    
            $error = $e;
        }

        return [$status, $error, $expenseType];
    }

    public function update(Request $request, ExpenseType $expenseType){
        $status = true;
        $error = null;

        $params = array_merge($request->all(), [
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => !is_null($request->is_active),
        ]);

        try {
            $expenseType->update($params);
        } catch (QueryException $e) {
            $status = false;    
            $error = $e;
        }

        return [$status, $error, $expenseType];
    }

    public function destroy(ExpenseType $expenseType){
        $status = true;
        $error = null;

        try {
            $expenseType->update([
                'is_active' => false,
            ]);
        } catch (QueryException $e) {
            $status = false;    
            $error = $e;
        }

        return [$status, $error];
    }
}
