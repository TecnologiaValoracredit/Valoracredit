<?php

namespace App\Services;

use App\Models\User;

class UserService {
    public function __construct() {

    }

    public function createRandomEntryDateForAllUsers() {
        $users = User::all();

        foreach ($users as $user) {
            $min = strtotime('2024-01-01');
            $max = strtotime('2026-05-26');

            $rand = random_int($min, $max);
            $rand_date = date('Y-m-d', $rand);

            $user->update([
                'entry_date' => $rand_date ?? null,
            ]);
        }
    }

    public function createRandomBirthDateForAllUsers() {
        $users = User::all();

        foreach ($users as $user) {
            $min = strtotime('1990-01-01');
            $max = strtotime('2003-01-01');

            $rand = random_int($min, $max);
            $rand_date = date('Y-m-d', $rand);

            $user->update([
                'birthday' => $rand_date ?? null,
            ]);
        }
    }
}