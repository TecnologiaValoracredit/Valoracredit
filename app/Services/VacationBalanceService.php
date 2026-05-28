<?php

namespace App\Services;

use App\Models\User;
use App\Models\VacationBalance;
use App\Models\VacationPolicy;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use function Safe\error_log;

class VacationBalanceService {
    public function __construct() {

    }

    public function store(){
        $status = true;
        $error = null;

        try {
            $user = auth()->user();
            $vacationBalance = $this->autoCreateBalance($user);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [ $status, $error, $vacationBalance ];
    }
    public function update(Request $request, VacationBalance $vacation_balance){

    }
    public function destroy(Request $request, VacationBalance $vacation_balance ){

    }

    private function autoCreateBalance(User $user) {
        //CALCULATE TOTAL ACTIVE YEARS
        $activeYears = $user->getActiveYears();
        $policy = VacationPolicy::where('years_from', $activeYears)->first();

        //If policy is null, grab the latest
        // if ($policy == null);
        // $policy = VacationPolicy::latest()->first();

        try {
            $vacationBalance = VacationBalance::create([
                'user_id' => $user->id,
                'active_years' => $activeYears,
                'days_assigned' => $policy->days,
                'days_used' => 0,
                'days_remaining' => $policy->days,
                'advance_days_available' => $policy->advance_days,
                'advance_days_used' => 0,
            ]);
        } catch (QueryException $e) {
            throw $e;
        }

        return $vacationBalance;
    }

    public function createBalanceForUsersWithoutIt() {
        $users = User::where('is_active', 1)->doesntHave('vacationBalance')->get();

        foreach ($users as $user) {
            try {
                $this->autoCreateBalance($user);
            } catch (\Throwable $th) {
                error_log("Error creating balance for {$user->name}. Error: {$th->getMessage()}");
                continue;
            }
        }
    }
}