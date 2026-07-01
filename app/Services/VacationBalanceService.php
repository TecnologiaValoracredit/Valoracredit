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
        $activeYears = $user->getActiveTimeInYears();
        $policy = VacationPolicy::where('years_from', $activeYears)->where('is_active', 1)->first();

        //If policy is null, grab the latest
        if ($policy == null){
            $policy = VacationPolicy::latest()->where('is_active', 1)->first();
        }

        $canHaveAdvanceDays = $user->getActiveTimeInMonths() >= $policy->applicable_month_range;
        try {
            $vacationBalance = VacationBalance::create([
                'user_id' => $user->id,
                'active_years' => $activeYears,
                'days_assigned' => $policy->days,
                'days_used' => 0,
                'days_remaining' => $policy->days,
                'advance_days_available' => $canHaveAdvanceDays ? $policy->advance_days : 0,
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

    //EXECUTE EVERY FIRST MONDAY OF MONTH
    public function recalculateBalanceForAll() {
        $this->createBalanceForUsersWithoutIt();
        $users = User::with('vacationBalance')->where('is_active', 1)->get();

        foreach ($users as $user) {
            try {
                $this->recalculateBalance($user);
            } catch (\Throwable $th) {
                error_log("Error recalculating balance for {$user->name}. Error: {$th->getMessage()}");
                continue;
            }
        }
    }

    private function recalculateBalance(User $user) {
            $activeTimeInYears = $user->getActiveTimeInYears();
            $activeTimeInMonths = $user->getActiveTimeInMonths();

            $balance = $user->vacationBalance;
            $policy = VacationPolicy::where('years_from', $activeTimeInYears)->where('is_active', 1)->first();
            
            //If policy is null, grab the latest
            if ($policy == null) {
                $policy = VacationPolicy::latest()->where('is_active', 1)->first();
            }

            $params = null;
            //Si el usuario ya cumplió mas años activo, actualiza la información de su balance
            if ($activeTimeInYears > $balance->active_years) {
                $advanceDaysUsed = $balance->advance_days_used;
                $canHaveAdvanceDays = $activeTimeInMonths >= $policy->applicable_month_range;
                $params = [
                    'active_years' => $activeTimeInYears,
                    'days_assigned' => $policy->days,
                    'days_used' => $advanceDaysUsed,
                    'days_remaining' => ($policy->days - $advanceDaysUsed),
                    'advance_days_available' => $canHaveAdvanceDays ? $policy->advance_days : 0,
                    'advance_days_used' => 0,
                ];
            }
            //Ya que esta funcion se ejecuta cada mes, tambien checa si no se han gastado ya de sus dias de vacaciones en avance, cosa que indicaría que ya se le habían asignado días en una ocasión pasada
            else if ($activeTimeInMonths >= $balance->applicable_month_range && $balance->advance_days_used == 0) {
                $params = [
                    'advance_days_available' => $policy->advance_days,
                ];
            }

            if ($params !== null) {
                $balance->update($params);                    
            }
    }
}