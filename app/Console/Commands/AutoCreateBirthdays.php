<?php

namespace App\Console\Commands;

use App\Services\UserService;
use App\Services\BirthdayService;
use Illuminate\Console\Command;

class AutoCreateBirthdays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthdays:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea fechas de cumpleaños para usuarios que no cuenten con una';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $userService = new UserService();
        // $userService->createRandomBirthDateForAllUsers();

        $service = new BirthdayService();
        $service->createBirthdaysForUsersWithoutIt();
        $service->createCalendarEvents();

        return Command::SUCCESS;
    }
}
