<?php

namespace App\Imports;

use App\Models\SSale;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;

class SalesImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return SSale|null
     */
    public function collection(Collection $rows)
    {
        dd("a");
        $sstatus = null;
        $grant_date = null;
        $institution = null;
        $sbranch = null;
        $creditType = null;
        $s_coordinator = null;

        foreach ($rows as $row) {
             SSale::create([
                'credit_id' => trim($row[1]), 
                'client_name' => trim($row[6]),
                'credit_amount' => trim($row[8]),
                'opening_amount' => trim($row[9]),
                'total_amount' => trim($row[8]) + trim($row[9]),
                // 's_status_id' => $sstatus->id,
                // 'grant_date' => $grant_date,
                // 'institution_id' => $institution->id,
                // 's_branch_id' => $sbranch->id,
                // 's_credit_type_id' => $creditType->id,
                // 's_coordinator_id' => $s_coordinator->id,

                //    'name'     => $row[0],
                //    'email'    => $row[1], 
                //    'password' => Hash::make($row[2]),
            ]);
        }
    }
}