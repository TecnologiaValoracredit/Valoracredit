<?php

namespace App\Models;

use App\Enums\RequisitionApprovalDecisionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio', 
        'request_id',
        'boss_id',
        'current_status_id',
        'current_owner_permission',
        'payment_type_id',
        'amount',
        'request_date',
        'departament_id',
        'branch_id',
        'supplier_id',
        'created_by', 
        'updated_by',
        'cancelled_at',
        'cancelled_by',
        'is_urgent',
        'is_active',
        'notes',
        'created_at',
        'updated_at',
        'requisition_global_id',
        'expense_type_id',
        'bank_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }
    public function boss()
    {
        return $this->belongsTo(User::class, 'boss_id','id');
    }
    public function paymentType()
    {
        return $this->belongsTo("App\Models\PaymentType", "payment_type_id", "id");
    }
    public function bank()
    {
        return $this->belongsTo("App\Models\Bank", "bank_id", "id");
    }
    public function requisitionStatus()
    {
        return $this->belongsTo("App\Models\RequisitionStatus", "current_status_id", "id");
    }
    public function expenseType()
    {
        return $this->belongsTo("App\Models\ExpenseType", "expense_type_id", "id");
    }
    public function supplier()
    {
        return $this->belongsTo("App\Models\Supplier", "supplier_id", "id");
    }
    public function requisitionRows()
    {
        return $this->hasMany("App\Models\RequisitionRow", "requisition_id", "id");
    }
    public function departament()
    {
        return $this->belongsTo("App\Models\Departament", "departament_id", "id");
    }
    public function global()
    {
        return $this->belongsTo("App\Models\RequisitionGlobal", "requisition_global_id", "id");
    }
    public function user()
    {
        return $this->belongsTo("App\Models\User", "request_id", "id");
    }
    public function lastLog(){
        return $this->hasOne("App\Models\RequisitionLog", "requisition_id", "id")
        ->latestOfMany();
    }
    public function lastApproval(){
        return $this->hasOne("App\Models\RequisitionApproval", "requisition_id", "id")
        ->latestOfMany();
    }
    public function policy(){
        return $this->hasOne("App\Models\RequisitionEntry", "requisition_id", "id")
        ->latestOfMany();
    }
    public function payment(){
        return $this->hasOne("App\Models\RequisitionPayment", "requisition_id", "id")
        ->latestOfMany();
    }
    public function logs(){
        return $this->hasMany("App\Models\RequisitionLog", 'requisition_id', 'id');
    }
    public function roleApprovedApproval(string $roleName){
        $role = Role::where('name', $roleName)->first();
        
        return $this->approvals
        ->where('role_id', $role->id)
        ->where('decision', RequisitionApprovalDecisionEnum::APPROVED->value)
        ->where('requisition_global_id', $this->requisition_global_id)
        ->where('is_valid', true)
        ->first();
    }
    public function latestRoleApproval(string $roleName){
        $role = Role::where('name', $roleName)->first();

        return $this->approvals
            ->where('role_id', $role->id)
            ->where('requisition_global_id', $this->requisition_global_id)
            ->where('is_valid', true)
            ->sortByDesc('id')
            ->first();
    }
    public function roleReturnedApproval(string $roleName){
        $role = Role::where('name', $roleName)->first();

        return $this->approvals
        ->where('role_id', $role->id)
        ->where('decision', RequisitionApprovalDecisionEnum::RETURNED->value)
        ->where('requisition_global_id', $this->requisition_global_id)
        ->where('is_valid', true)
        ->first();
    }
    public function reviewedByRole(string $roleName){
        $role = Role::where('name', $roleName)->first();

        return $this->approvals
        ->where('role_id', $role->id)
        ->where('is_valid', true)
        ->first();
    }
    public function adminSignatureApproval(){
        return $this->approvals
        ->where('decision', 'Aprobada')
        ->where('requisition_global_id', $this->requisition_global_id)
        ->where('is_valid', true)
        ->first(fn ($approval) => $approval->user->hasPermissions('requisition_globals.adminSignature'));
    }
    public function approvals(){
        return $this->hasMany("App\Models\RequisitionApproval", 'requisition_id', 'id');
    }

    public function totalRows()
    {
        $subtotal = 0;
        $totalIva = 0;
        $total = 0;
        foreach($this->requisitionRows as $row){
            $subtotal += $row->product_quantity * $row->product_cost; 
            if(!$row->has_iva){
                $totalIva += ($row->product_quantity * $row->product_cost) * 0.16;          
            } 
        }
        $total = $subtotal + $totalIva;

        return ['subtotal' => $subtotal, 'totalIva' => $totalIva, 'total' => $total];
    }

    public function isAuthor(User $user){
        // dd($user->id,  $this->user_id);
        dd($this);
        if ($user->id == $this->request_id){
            return true;
        } else{
            return false;
        }
    }

    public function getProductsCount(){
        return count($this->requisitionRows);
    }

    public function invalidPreviousDecisions(){
        foreach ($this->approvals as $key => $approval) {
            $approval->update([
                'is_valid' => false,
            ]);
        }
    }
}
