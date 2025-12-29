<?php

namespace App\Http\Helpers\ContractVariables;

use Carbon\Carbon;

class Edad
{
    /**
     * Procesa el valor original.
     * 
     * @param mixed $value   → valor del model_column (ej. '1995-04-12')
     * @param mixed $model   → instancia del modelo si la necesitas
     * @return string        → valor final que se insertará en el contrato
     */
    public static function handle($value, $model = null)
    {
        if (!$value) {
            return '';
        }

        return Carbon::parse($value)->age;
    }
}
