<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FFlux extends Model
{
    use HasFactory;

    protected $fillable = [
        'f_account_id', 
        'accredit_date',
        'f_beneficiary_id',
        'concept',
        'amount',
        'f_movement_type_id', 
        'notes1',
        'notes2',
        'comments',
        'f_status_id',
        'f_cartera_status_id',
        'f_clasification_id',
        'f_cob_clasification_id',
        'f_expense_type_id',
        'tracking_key',
        'is_active',
        'created_by',
        'updated_by',
        'notes'
    ];
    
    public function fAccount()
    {
        return $this->belongsTo("App\Models\FAccount", "f_account_id", "id");
    }

    public function fBeneficiary()
    {
        return $this->belongsTo("App\Models\FBeneficiary", "f_beneficiary_id", "id");
    }

    public function fStatus()
    {
        return $this->belongsTo("App\Models\FStatus", "f_status_id", "id");
    }

    public function fCarteraStatus()
    {
        return $this->belongsTo("App\Models\FCarteraStatus", "f_cartera_status_id", "id");
    }

    public function fMovementType()
    {
        return $this->belongsTo("App\Models\FMovementType", "f_movement_type_id", "id");
    }

    public function fClasification()
    {
        return $this->belongsTo("App\Models\FClasification", "f_clasification_id", "id");
    }

    public function fCobClasification()
    {
        return $this->belongsTo("App\Models\FCobClasification", "f_cob_clasification_id", "id");
    }

    public function fExpenseType()
    {
        return $this->belongsTo("App\Models\FExpenseType", "f_expense_type_id", "id");
    }

    public function previousBalance()
    {
        $init_balance = $this->fAccount->init_balance ?? 0;

        $movimientosAnteriores = self::where('f_account_id', $this->f_account_id)
            ->where(function ($query) {
                $query->where('accredit_date', '<', $this->accredit_date)
                    ->orWhere(function ($q) {
                        $q->where('accredit_date', $this->accredit_date)
                            ->where('id', '<', $this->id);
                    });
            })
            ->get();

        // Calcular saldo acumulado a partir del saldo inicial
        $saldo = $movimientosAnteriores->reduce(function ($carry, $item) {
            if ($item->f_movement_type_id == 1) {
                return $carry + floatval($item->amount); // ingreso
            } elseif ($item->f_movement_type_id == 2) {
                return $carry - floatval($item->amount); // egreso
            }
            return $carry;
        }, $init_balance);

        return $saldo;
    }

    public function actualBalance()
    {
        return $this->previousBalance() + (
            $this->f_movement_type_id == 1
                ? floatval($this->amount)
                : -floatval($this->amount)
        );
    }

}
