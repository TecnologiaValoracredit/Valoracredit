<?php

namespace App\Models;

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
        'created_by', 
        'updated_by',
        'cancelled_at',
        'cancelled_by',
        'is_urgent',
        'notes',
        'created_at',
        'updated_at',
        'requisition_global_id',
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    public function paymentType()
    {
        return $this->belongsTo("App\Models\PaymentType", "payment_type_id", "id");
    }
    public function requisitionStatus()
    {
        return $this->belongsTo("App\Models\RequisitionStatus", "current_status_id", "id");
    }
    public function requisitionRows()
    {
        return $this->hasMany("App\Models\RequisitionRow", "requisition_id", "id");
    }
    public function departament()
    {
        return $this->belongsTo("App\Models\Departament", "departament_id", "id");
    }
    public function user()
    {
        return $this->belongsTo("App\Models\User", "request_id", "id");
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
}
