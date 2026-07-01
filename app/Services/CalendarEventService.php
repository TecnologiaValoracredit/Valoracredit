<?php

namespace App\Services;

use App\Models\CalendarEvent;
use App\Models\Holiday;

class CalendarEventService {
    public function getEvents() {
        return CalendarEvent::all()->map(function ($event) {
            $data = [
                'title' => $event->title,
                'description' => $event->description,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'color' => $event->color,
            ];

            if ($event->event_type === 'holiday' || $event->event_type === 'birthday') {
                $data['rrule'] = [
                    'freq' => 'yearly',
                    'dtstart' => $event->start_date,
                ];
            }
 
            return $data;
        });
    }

    public function store() {

    }
}