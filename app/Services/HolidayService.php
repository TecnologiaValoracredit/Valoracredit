<?php

namespace App\Services;

use App\Models\CalendarEvent;
use App\Models\Holiday;
use App\Models\User;

class HolidayService {
    public function createCalendarEvents() {
        $adminUser = User::whereHas('role', function($role) {
            $role->where('name', 'Admin');
        })
        ->first();

        Holiday::each(function ($holiday) use($adminUser) {
            if ($holiday->calendarEvents()->exists()) return;

            $holiday->calendarEvents()->create([
                'event_type' => 'Festivo',
                'title' => $holiday->name,
                'description' => $holiday->description,
                'start_date' => $holiday->date,
                'end_date' => $holiday->date,
                'all_day' => true,
                'color' => '#000000',
                'user_id' => $adminUser->id,
            ]);
        });
    }
}