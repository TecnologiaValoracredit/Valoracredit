<?php

namespace App\Http\Controllers;

use App\Services\CalendarEventService;
use Illuminate\Http\Request;

class CalendarEventController extends Controller
{
    public function __construct(private CalendarEventService $service) { }

    public function events() {
        $events = $this->service->getEvents();

        return $events;
    }
}
