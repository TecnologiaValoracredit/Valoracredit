<?php

namespace App\Services;

use App\Models\User;
use App\Models\Birthday;
use Illuminate\Database\QueryException;

class BirthdayService {
    public function createCalendarEvents() {
        $adminUser = User::whereHas('role', function($role) {
            $role->where('name', 'Admin');
        })
        ->first();

        Birthday::each(function ($birthday) use($adminUser) {
            if ($birthday->calendarEvents()->exists()) return;
            
            $birthday->calendarEvents()->create([
                'event_type' => 'Cumpleaños',
                'title' => "Cumpleaños - {$birthday->user->name}",
                'description' => "Cumpleaños de {$birthday->user->name}",
                'start_date' => $birthday->date,
                'end_date' => $birthday->date,
                'all_day' => true,
                'color' => '#ff00bf',
                'user_id' => $adminUser->id,
            ]);
        });
    }

    public function autoCreateBirthday(User $user) {
        try {
            Birthday::create([
                'user_id' => $user->id,
                'date' => $user->birthday,
            ]);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    public function createBirthdaysForUsersWithoutIt() {
        $users = User::where('is_active', 1)->doesntHave('birthdayEvent')->get();

        foreach ($users as $user) {
            try {
                $this->autoCreateBirthday($user);
            } catch (\Throwable $th) {
                error_log("Error birthday for {$user->name}. Error: {$th->getMessage()}");
                break;
            }
        }
    }
}