<?php

namespace App\Console\Commands;

use App\Services\UserService;
use App\Services\VacationBalanceService;
use Illuminate\Console\Command;

class autoCreateVacationBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacationBalances:autoCreate';

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
        $userService = new UserService();
        $userService->createRandomEntryDateForAllUsers();

        $service = new VacationBalanceService();
        $service->createBalanceForUsersWithoutIt();

        return Command::SUCCESS;
    }
}
