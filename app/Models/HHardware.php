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
        'name', 'user_id','h_device_type_id','h_brand_id','serial_number',
        'specifications', 'branch_id', 'company_id',
        'purchase_date', 'image', 'created_by','created_at','is_active', 'notes',
        'color','custom_serial_number'
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", "id");
    }

    public function hDeviceType()
    {
        return $this->belongsTo("App\Models\HDeviceType", "h_device_type_id", "id");
    }

    public function hBrand()
    {
        return $this->belongsTo("App\Models\HBrand", "h_brand_id", "id");
    }

    public function branch()
    {
        return $this->belongsTo("App\Models\Branch", "branch_id", "id");
    }

    public function company()
    {
        return $this->belongsTo("App\Models\Company", "company_id", "id");
    }

    protected static function booted()
    {
        static::creating(function ($hardware) {
            if (empty($hardware->custom_serial_number)) {
                $hardware->custom_serial_number = 'SN-' . strtoupper(uniqid('HW-'));
            }
        });
    }
}
