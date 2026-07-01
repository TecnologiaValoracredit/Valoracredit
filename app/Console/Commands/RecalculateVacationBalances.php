<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
USE App\Services\VacationBalanceService;

class RecalculateVacationBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacationBalances:recalculateAll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalcula el saldo de vacaciones de los usuarios';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = new VacationBalanceService();
        $service->recalculateBalanceForAll();

        return Command::SUCCESS;
    }
}
