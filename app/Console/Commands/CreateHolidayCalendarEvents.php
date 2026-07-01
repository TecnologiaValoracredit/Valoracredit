<?php

namespace App\Console\Commands;

use App\Services\HolidayService;
use Illuminate\Console\Command;

class CreateHolidayCalendarEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holidays:createCalendarEvents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea eventos de calendario en base a los días festivos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $service = new HolidayService();
        $service->createCalendarEvents();
        return Command::SUCCESS;
    }
}
