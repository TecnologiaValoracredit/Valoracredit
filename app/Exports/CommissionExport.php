<?php

namespace App\Exports;

use App\Models\Commission;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommissionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Commission::all();
    }
}
