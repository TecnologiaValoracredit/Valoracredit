<?php

namespace App\Imports;

use App\Models\Expedient;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;

class ExpedientImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return Expedient|null
     */
    public function collection(Collection $rows)
    {
        
        dd("hola");
        // foreach ($rows as $row) {
        //      Expedient::create([
                
        //     ]);
        // }
    }
}