<?php

namespace App\Exports\Commissions;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Commissions\CommissionSheet;
use App\Exports\Commissions\PolizaSheet;

class CommissionExport implements WithMultipleSheets
{
    protected $commissions;
    protected $poliza;
    protected $dates;
    protected $outSourcing;

    public function __construct($commissions, $poliza, $dates, $outSourcing)
    {
        $this->commissions = $commissions;
        $this->poliza = $poliza;
        $this->dates = $dates;
        $this->outSourcing = $outSourcing;
    }

    public function sheets(): array
    {
        return [
            new CommissionSheet($this->commissions, $this->dates),
            new PolizaSheet($this->poliza, $this->dates, $this->outSourcing),
        ];
    }



}
