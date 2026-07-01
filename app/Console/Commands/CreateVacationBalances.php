<?php

namespace App\Console\Commands;

use App\Services\UserService;
use App\Services\VacationBalanceService;
use Illuminate\Console\Command;

class CreateVacationBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacationBalances:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea balances de vacaciones para todos los usuarios';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = new VacationBalanceService();
        $service->createBalanceForUsersWithoutIt();

        return Command::SUCCESS;
    }
}
