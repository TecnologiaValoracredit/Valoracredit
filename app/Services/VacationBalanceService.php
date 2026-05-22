<?php

namespace App\Services;

use App\Models\User;
use App\Models\VacationBalance;
use App\Models\VacationPolicy;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VacationBalanceService {
    public function __construct() {

    }

    public function store(){
        $user = auth()->user();
        $this->autoCreateBalance($user);

    }
    public function update(Request $request, VacationBalance $vacation_balance){

    }
    public function destroy(Request $request, VacationBalance $vacation_balance ){

    }

    private function autoCreateBalance(User $user) {
        //CALCULATE TOTAL ACTIVE YEARS
        $activeYears = $user->getActiveYears();
        $policy = VacationPolicy::where('years_from', $activeYears)->first();
        
        $balance = VacationBalance::create([
            'user_id' => $user->id,
            'active_years' => $activeYears,
            'days_assigned' => $policy->days,
            'days_used' => 0,
            'days_remaining' => $policy->days,
            'advance_days_available' => $policy->advance_days,
            'advance_days_used' => 0,
        ]);

        dd($balance);
    }
}