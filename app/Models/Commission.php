<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        's_sale_id',
        'amount_received',
        'commission_percentage',
        'is_active', 
        'created_by', 
        'updated_by',
    ];

    //Relación que se tiene con los usuarios (coordinador y promnotor)
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relación con la venta
    public function sSale(){
        return $this->belongsTo(SSale::class);
    }
    
}
