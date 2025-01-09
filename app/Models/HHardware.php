<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HHardware extends Model
{
    use HasFactory;
    protected $table = "h_hardwares";
    protected $fillable=
    [
        'user_id','h_device_type_id','h_brand_id','serial_number','specifications',
        'purchase_date', 'image', 'created_by','created_at','is_active', 'notes', 'color','custom_serial_number'
    ];

    protected static function booted()
    {
        static::creating(function ($hardware) {
            if (empty($hardware->custom_serial_number)) {
                $hardware->custom_serial_number = 'SN-' . strtoupper(uniqid('HW-'));
            }
        });
    }
}
