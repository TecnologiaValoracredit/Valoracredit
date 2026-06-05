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
    public function update(Request $request, VacationBalance $vacationBalance){
        $status = true;
        $error = null;

        $requestInputs = [
            'active_years' => $request->input('active_years'),
            'days_assigned' => $request->input('days_assigned'),
            'days_remaining' => $request->input('days_remaining'),
            'days_used' => $request->input('days_used'),
            'advance_days_available' => $request->input('advance_days_available'),
            'advance_days_used' => $request->input('advance_days_used'),
        ];

        try {
            $this->updateVacationBalance($vacationBalance, $requestInputs);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [ $status, $error ];
    }
    public function destroy(Request $request, VacationBalance $vacationBalance ){

    }

    //HELPERS

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

    public function updateVacationBalance(VacationBalance $vacationBalance, $requestInputs) {
        try {
            $vacationBalance->update([
                'active_years' => $requestInputs['active_years'],
                'days_assigned' => $requestInputs['days_assigned'],
                'days_remaining' => $requestInputs['days_remaining'],
                'days_used' => $requestInputs['days_used'],
                'advance_days_available' => $requestInputs['advance_days_available'],
                'advance_days_used' => $requestInputs['advance_days_used'],
            ]);
        } catch (QueryException $e) {
            throw $e;
        }
    }
}