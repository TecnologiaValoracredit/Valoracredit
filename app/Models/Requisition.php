<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [ 
        //Agregar columna 'folio' como texto
        'user_id', //Cambia por request_id -- la relacion sigue igual a users
        'requisition_status_id', //Cambia por current_status_id -- la relacion sigue igual
        // 'current_owner_permission' es para saber quien debe actuar (rechazar, autorizar, etc) pero sobre quien tenga ese permiso, no sobre rol. Es un texto directo con module.permission, por ejemplo: requisitions.tesoreria
        'payment_type_id',
        'amount',
        'request_date', //solo informativo de cuando se solicitó -- no se usa para el flujo
        'departament_id',
        'branch_id',
        //'requisition_global_id' si está dentro de una requisicion global, es una relacion a requisitions_globals
        'approval_boss_id', //Quitarlo
        'boss_approval_date', //Quitarlo
        'approval_admin_id', //Quitarlo
        'admin_approval_date', //Quitarlo
        'approval_chief_id', //Quitarlo
        'chief_approval_date', //Quitarlo
        'is_active',  //Quitarlo
        'created_by', 
        'updated_by',
        //cancelled_at nullable - datetime
        //cancelled_by nullable - relacion a users
        // 'is_urgent' booleano
        'notes',
        //Todo lo demas quitarlo lo de las firmas
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
        return $this->belongsTo("App\Models\RequisitionStatus", "requisition_status_id", "id");
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
        return $this->belongsTo("App\Models\User", "user_id", "id");
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
        if ($user->id == $this->user_id){
            return true;
        } else{
            return false;
        }
    }

    

}
