<?php

namespace App\Services;

use App\Enums\VacationStatusEnum;
use App\Models\Vacation;
use App\Models\VacationDate;
use App\Models\VacationStatus;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class VacationService {
    public function __construct() {

    }

    public function store(Request $request){
        $status  = true;
        $error = null;
        $vacation = null;
        
        $requestInputs = [
            'total_days' => $request->input('total_days'),
            'reason' => $request->input('reason'),  
            'notes' => $request->input('notes'),
        ];
        $dates = collect($request->all())
            ->filter(fn($value, $key) => str_contains($key, 'vac-date'))
            ->values()
        ->all();

        try {
            $vacation = $this->createVacation($requestInputs);
            $this->createVacationDates($vacation, $dates);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [ $status, $error, $vacation ];
    }

    public function update(Request $request, Vacation $vacation){

    }

    public function destroy(Request $request, Vacation $vacation ){

    }

    public function cancel(Request $request, Vacation $vacation) {
        $status = true;
        $error = null;
        
        return [ $status, $error ];
    }

    public function send(Request $request, Vacation $vacation) {
        $status = true;
        $error = null;
        
        return [ $status, $error ];
    }

    public function approve(Request $request, Vacation $vacation) {
        $status = true;
        $error = null;
        
        return [ $status, $error ];
    }
    
    public function deny(Request $request, Vacation $vacation) {
        $status = true;
        $error = null;
        
        return [ $status, $error ];
    }

    //HELPERS

    private function createVacation($requestInputs) {
        $user = auth()->user();
        $vacationStatus = VacationStatus::where('name', VacationStatusEnum::CREATED->value)->first();

        $balance = $user->vacationBalance;
        $daysAvailableBefore = null;
        $daysAvailableAfter = null;
        $normalDaysUsed = true;

        //SI TIENE DIAS POR USAR Y PUEDE GASTAR DE ELLOS
        if ($balance->days_remaining > 0 &&
        ($balance->days_remaining - $requestInputs['total_days']) >= 0){
            //Calculo usando dias normales
            $daysAvailableBefore = $balance->days_remaining;
            $daysAvailableAfter = $balance->days_remaining - $requestInputs['total_days'];
        }
        else if($balance->advance_days_available > 0 &&
        ($balance->advance_days_available - $requestInputs['total_days']) >= 0){
            //Calculo usando dias en avance
            $daysAvailableBefore = $balance->advance_days_available;
            $daysAvailableAfter = $balance->advance_days_available - $requestInputs['total_days'];
            $normalDaysUsed = false;
        }
        else {
            throw new ErrorException("No cuenta con los días suficientes para pedir vacaciones");
        }

        //CREATE VACATION
        try {
            $vacation = Vacation::create([
                'user_id' => $user->id,
                'boss_id' => $user->boss->id ?? $user->id,
                'total_days' => $requestInputs['total_days'],
                'reason' => $requestInputs['reason'],
                'notes' => $requestInputs['notes'],
                'vacation_status_id' => $vacationStatus->id,
                'days_available_before' => $daysAvailableBefore,
                'days_available_after' => $daysAvailableAfter,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            //UPDATE VACATION BALANCE
            if ($normalDaysUsed){
                $balance->update([
                    'days_used' => $requestInputs['total_days'],
                    'days_remaining' => $daysAvailableAfter,
                ]);
            }
            else {
                $balance->update([
                    'advace_days_used' => $requestInputs['total_days'],
                    'advance_days_available' => $daysAvailableAfter,
                ]);
            }

        } catch (QueryException $e) {
            throw $e;
        }

        //RETURN VACATION
        return $vacation;
    }

    private function createVacationDates(Vacation $vacation, $dates) {
        try {
            foreach ($dates as $key => $date) {
                VacationDate::create([
                    'vacation_id' => $vacation->id,
                    'date' => $date,
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}