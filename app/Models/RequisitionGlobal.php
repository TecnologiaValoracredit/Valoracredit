<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RequisitionGlobal extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'is_active',
        'created_at',
        'updated_at',
        'application_date',
        'requisition_global_status_id',
    ];

    public function creator(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function requisitionGlobalStatus(){
        return $this->belongsTo(RequisitionGlobalStatus::class, 'requisition_global_status_id', 'id');
    }

    public function requisitions(){
        return $this->hasMany(Requisition::class, 'requisition_global_id', 'id');
    }

    public function getRequisitionsByExpenseType(int $id){
        return $this->requisitions
        ->where('expense_type_id', $id);
    }

    public function getExpenseTypeTotal(int $id){
        return $this->requisitions
        ->where('expense_type_id', $id)
        ->sum('amount');
    }

    public function totalGlobalAmount(){
        return $this->requisitions
        ->sum('amount');
    }

    public function suppliersWithTotals(){
        return $this->requisitions
        ->groupBy(fn ($req) => $req->supplier->name)
        ->map(fn ($reqs) => $reqs->sum('amount'));
    }

    public function suppliers(){
        return $this->requisitions
        ->pluck('supplier.name')
        ->unique()
        ->values();
    }

    public function expenseTypes(){
        return $this->requisitions
        ->pluck('expenseType.name', 'expenseType.id')
        ->unique()
        ->toArray();
    }

    public function roleHasNotVerified(string $roleName){
        $hasNotVerified = false;

        foreach ($this->requisitions as $key => $req) {
            if (!$req->reviewedByRole($roleName)){
                $hasNotVerified = true;
                break;
            }
        }

        return $hasNotVerified;
    }
}
