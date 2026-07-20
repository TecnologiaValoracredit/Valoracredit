<?php

namespace App\Services;

use App\Enums\RolesEnum;
use App\Enums\VacationDecisionEnum;
use App\Enums\VacationStatusEnum;
use App\Enums\BalanceUsedEnum;
use App\Models\Role;
use App\Models\User;
use App\Models\Vacation;
use App\Models\VacationDate;
use App\Models\VacationApproval;
use App\Models\VacationStatus;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Mail\VacationMail;
use Illuminate\Support\Facades\Mail;

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

        $vacation = null;
        try {
            foreach ($dates as $key => $date) {
                $dt = Carbon::parse($date);

                if ($dt < Carbon::today()) {
                    throw new ErrorException("Fechas ingresadas invalidas");
                }
            }
            
            $vacation = $this->createVacation($requestInputs);
            $this->createVacationDates($vacation, $dates);

            if ($request->input('sendOnCreate')){
                $this->sendVacation($vacation);
            }
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [ $status, $error, $vacation ];
    }

    public function update(Request $request, Vacation $vacation){
        $status = true;
        $error = null;

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
            $this->updateVacation($vacation, $requestInputs);
            $this->updateVacationDates($vacation, $dates);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [ $status, $error ];
    }

    public function destroy(Vacation $vacation ){
        $status = true;
        $error = null;

        try {
            $this->deleteVacation($vacation);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [$status, $error];
    }

    public function cancel(Vacation $vacation) {
        $status = true;
        $error = null;

        try {
            $this->cancelVacation($vacation);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [$status, $error];
    }

    public function send(Request $request, Vacation $vacation) {
        $status = true;
        $error = null;

        try {
            $this->sendVacation($vacation);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }
        
        return [ $status, $error ];
    }

    public function approve(Request $request, Vacation $vacation) {
        $status = true;
        $error = null;
        
        $requestInputs = [
            'notes' => $request->input('notes')
        ];

        try {
            $this->approveVacation($vacation, $requestInputs);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [ $status, $error ];
    }
    
    public function deny(Request $request, Vacation $vacation) {
        $status = true;
        $error = null;

        $requestInputs = [
            'notes' => $request->input('notes')
        ];

        try {
            $this->denyVacation($vacation, $requestInputs);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }
        
        return [ $status, $error ];
    }

    //HELPERS

    public function isHrOrHasPermissions() {
        return auth()->user()->hasPermissions('vacations.seeAllVacations');
    }
    public function isBoss(Vacation $vacation) { 
        return $vacation->boss_id == auth()->id();
    }
    public function canAction($vacation) {
        return in_array($vacation->status->name, [VacationStatusEnum::CREATED->value, VacationStatusEnum::PENDING_BOSS->value, VacationStatusEnum::PENDING_HR->value]);
    }
    public function canSend($vacation) {
        return $vacation->status->name == VacationStatusEnum::CREATED->value;
    }
    public function canDestroy($vacation) {
        return $vacation->status->name == VacationStatusEnum::CREATED->value;
    }

    private function createVacation($requestInputs) {
        $user = auth()->user();
        $vacationStatus = VacationStatus::where('name', VacationStatusEnum::CREATED->value)->first();

        $balance = $user->vacationBalance;
        $daysAvailableBefore = null;
        $daysAvailableAfter = null;
        $balanceUsed = null;

        //SI TIENE DIAS POR USAR Y PUEDE GASTAR DE ELLOS
        if ($balance->days_remaining > 0 &&
        ($balance->days_remaining - $requestInputs['total_days']) >= 0){
            //Calculo usando dias normales
            $daysAvailableBefore = $balance->days_remaining;
            $daysAvailableAfter = $daysAvailableBefore - $requestInputs['total_days'];

            $balanceUsed = BalanceUsedEnum::NORMAL;
        }
        else if($balance->advance_days_available > 0 &&
        ($balance->advance_days_available - $requestInputs['total_days']) >= 0){
            //Calculo usando dias en avance
            $daysAvailableBefore = $balance->advance_days_available;
            $daysAvailableAfter = $daysAvailableBefore - $requestInputs['total_days'];

            $balanceUsed = BalanceUsedEnum::ADVANCE;
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
                'balance_used' => $balanceUsed->value,
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            //UPDATE VACATION BALANCE
            if ($balanceUsed == BalanceUsedEnum::NORMAL){
                $balance->update([
                    'days_used' => $requestInputs['total_days'],
                    'days_remaining' => $daysAvailableAfter,
                ]);
            }
            else {
                $balance->update([
                    'advance_days_used' => $requestInputs['total_days'],
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
                    'created_at' => now(),
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function updateVacation(Vacation $vacation, $requestInputs) {
        $user = auth()->user();
        $balance = $user->vacationBalance;
        $previousTotalDays = $vacation->total_days;
        $daysAvailableBefore = null;
        $daysAvailableAfter = null;

        //Saca la diferencia entre la ultima cantidad de dias a tomar anteriores y la nueva cantidad
        $diff = $previousTotalDays - $requestInputs['total_days'];

        //Calcula si sumando / restando la diferencia, cae dentro de los dias que puede usar
        //Ejemplo (Dias anteriores = 4 -  Dias Nuevos = 3) = 1, Si balance de dias normales + (1) es mayor o igual a 0, es valido 
        //Ejemplo (Dias anteriores = 4 -  Dias Nuevos = 5) = -1, Si balance de dias normales + (-1) es mayor o igual a 0, es valido
        if ($vacation->balance_used == BalanceUsedEnum::NORMAL->value && ($balance->days_remaining + $diff >= 0)) 
        {
            $daysAvailableBefore = ($balance->days_remaining + $diff) + $requestInputs['total_days'];
            $daysAvailableAfter = $daysAvailableBefore- $requestInputs['total_days'];
         }
        else if($vacation->balance_used == BalanceUsedEnum::ADVANCE->value && ($balance->advance_days_available + $diff >= 0))
        {
            $daysAvailableBefore = ($balance->advance_days_available + $diff) + $requestInputs['total_days'];
            $daysAvailableAfter = $daysAvailableBefore - $requestInputs['total_days'];
        }
        else {
            throw new ErrorException("No cuenta con mas días de los especificados a tomar");
        }

        try {
            $vacation->update([
                'total_days' => $requestInputs['total_days'],
                'reason' => $requestInputs['reason'],
                'notes' => $requestInputs['notes'],
                'days_available_before' => $daysAvailableBefore,
                'days_available_after' => $daysAvailableAfter,
                'updated_by' => $user->id,
            ]);

            //UPDATE VACATION BALANCE
            if ($vacation->balance_used == BalanceUsedEnum::NORMAL->value){
                $balance->update([
                    'days_used' => $requestInputs['total_days'],
                    'days_remaining' => $daysAvailableAfter,
                ]);
            }
            else {
                $balance->update([
                    'advance_days_used' => $requestInputs['total_days'],
                    'advance_days_available' => $daysAvailableAfter,
                ]);
            }
        } catch (QueryException $e) {
            throw $e;
        }
    }

    private function updateVacationDates(Vacation $vacation, $dates) {
        $vacation->dates()->delete();

        $this->createVacationDates($vacation, $dates);
    }

    private function deleteVacation(Vacation $vacation) {
        try {
            $vacation->dates()->delete();

            $this->returnUnusedBalance($vacation);

            $vacation->update([
                'is_active' => false,
            ]);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    private function sendVacation(Vacation $vacation) {
        if ($vacation->user_id != auth()->id()) {
            throw new ErrorException("Solo el creador de las vacaciones puede cancelarlas");
        }

        if ($vacation->status->name != VacationStatusEnum::CREATED->value) {
            throw new ErrorException("No se puede enviar vacaciones previamente enviadas!");
        }

        $nextStatus = VacationStatus::where('name', VacationStatusEnum::PENDING_BOSS->value)->first();
        try {
            $vacation->update([
                'vacation_status_id' => $nextStatus->id,
            ]);

            $receivers = $vacation->boss;
            $receivers = auth()->user();

            $params = [
                'subject' => 'Vacaciones pendientes de aprobación',
                'title' => "Vacaciones enviadas para aprobación de Jefe Inmediato",
                'message' => 'Se ha enviadon unas vacaciones para su revisión y aprobación de Jefe Inmediato.',
                'url' => route('vacations.changeStatus', $vacation->id),
            ];
            $this->sendMail($receivers, $params);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    private function approveVacation(Vacation $vacation, $requestInputs) {
        if (!$this->isBoss($vacation) && !$this->isHrOrHasPermissions()) {
            throw new ErrorException("Solo el Jefe Inmediato o RH pueden autorizar vacaciones");
        }

        $params = [
            'vacation_id' => $vacation->id,
            'user_id' => auth()->id(),
            'decision' => VacationDecisionEnum::APPROVED->value,
            'notes' => $requestInputs['notes'],
        ];
        try {
            $this->createApproval($params);

            $nextStatus = VacationStatus::where('name', VacationStatusEnum::PENDING_HR->value)->first();
            $vacation->update([
                'vacation_status_id' => $nextStatus->id,
            ]);
        } catch (QueryException $e) {
            throw $e;
        }

        $vacation->refresh();
        $receivers = null;
        $params = null;
        if ($this->checkForApprovability($vacation)){
            try {
                $nextStatus = VacationStatus::where('name', VacationStatusEnum::APPROVED->value)->first();
                $vacation->update([
                    'vacation_status_id' => $nextStatus->id,
                ]);

                $this->createCalendarEvents($vacation);

                $receivers = $vacation->user;
                $receivers = User::where('id', 92)->first();

                $params = [
                    'subject' => 'Vacaciones aprobadas',
                    'title' => "Vacaciones aprobadas",
                    'message' => 'Sus vacaciones han sido aprobadas, ingrese al sistema para ver mas acerca de esta decisión.',
                    'url' => route('vacations.show', $vacation->id),
                ];
            } catch (QueryException $e) {
                throw $e;
            }
        }
        else {
            $hrRole = Role::where('name', 'Recursos Humanos')->first();
            $receivers = User::where('role_id', $hrRole->id)->get()->all();
            $receivers = User::where('id', 92)->first();

            $params = [
                'subject' => 'Vacaciones pendientes de aprobación',
                'title' => "Vacaciones enviadas para aprobación de Recursos Humanos",
                'message' => 'Se han enviado unas vacaciones para su revisión y aprobación de Recursos Humanos.',
                'url' => route('vacations.changeStatus', $vacation->id),
            ];
        }

        $this->sendMail($receivers, $params);
    }

    private function createCalendarEvents(Vacation $vacation) {
        $startDate = $vacation->startDate->date;
        $endDate = $vacation->endDate->date;

        $vacation->calendarEvents()->create([
            'event_type' => 'vacation',
            'title' => "Vacations - {$vacation->user->name}",
            'description' => $vacation->notes ?? "Vacaciones de {$vacation->user->name}",
            'start_date' => $startDate,
            'end_date' => $endDate,
            'all_day' => true,
            'color' => 'blue',
            'user_id' => $vacation->user_id,
        ]);
    }

    private function denyVacation(Vacation $vacation, $requestInputs) {
        if (!$this->isBoss($vacation) && !$this->isHrOrHasPermissions()) {
            throw new ErrorException("Solo el Jefe Inmediato o RH pueden rechazar vacaciones");
        }

        $params = [
            'vacation_id' => $vacation->id,
            'user_id' => auth()->id(),
            'decision' => VacationDecisionEnum::REJECTED->value,
            'notes' => $requestInputs['notes'],
        ];
        
        try {
            $this->createApproval($params);
            // $vacation->dates()->delete();

            $nextStatus = VacationStatus::where('name', VacationStatusEnum::REJECTED->value)->first();
            $vacation->update([
                'vacation_status_id' => $nextStatus->id,
            ]);
            $this->returnUnusedBalance($vacation);

            $receivers = $vacation->user;
            $receivers = auth()->user();

            $params = [
                'subject' => 'Vacaciones rechazadas',
                'title' => "Vacaciones rechazadas",
                'message' => 'Sus vacaciones han sido rechazadas, ingrese al sistema para ver mas acerca de esta decisión.',
                'url' => route('vacations.show', $vacation->id),
            ];
            $this->sendMail($receivers, $params);
        } catch (QueryException $e) {
            throw $e;
        }        
    }

    private function cancelVacation(Vacation $vacation) {
        if ($vacation->user_id != auth()->id()) {
            throw new ErrorException("Solo el creador de las vacaciones puede cancelarlas");
        }

        if (in_array($vacation->status->name, [VacationStatusEnum::CREATED->value, VacationStatusEnum::APPROVED->value, VacationStatusEnum::REJECTED->value])) {
            throw new ErrorException("No se pueden cancelar vacaciones previamente aprobadas, rechazadas o creadas");
        }

        $nextStatus = VacationStatus::where('name', VacationStatusEnum::CANCELLED->value)->first();
        try {
            $vacation->dates()->delete();
            
            $vacation->update([
                'vacation_status_id' => $nextStatus->id,
            ]);
            $this->returnUnusedBalance($vacation);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    private function returnUnusedBalance(Vacation $vacation){
        //Regresa los dias al balance usado
        $balance = $vacation->user->vacationBalance;
        $updatedDaysRemaining = $vacation->days_available_before;

        if ($vacation->balance_used == BalanceUsedEnum::NORMAL->value) {
            $balance->update([
                'days_used' => ($balance->days_used - $vacation->total_days),
                'days_remaining' => $updatedDaysRemaining,
            ]);
        }
        else {
            $balance->update([
                'advance_days_used' => ($balance->advance_days_used - $vacation->total_days),
                'advance_days_available' => $updatedDaysRemaining,
            ]);
        }
    }

    private function createApproval($params) {
        VacationApproval::create([
            'vacation_id' => $params['vacation_id'],
            'user_id' => $params['user_id'],
            'decision' => $params['decision'],
            'notes' => $params['notes'],
        ]);
    }

    private function checkForApprovability(Vacation $vacation) {
        return $vacation->isSelfApprovedWithPermissions('vacations.seeAllVacations') 
        || ($vacation->approvedWithPermissions('vacations.seeAllVacations') && $vacation->approvedByBoss());
    }

    private function sendMail($receivers, array $params){
        //Normaliza el arreglo                
        if (!is_array($receivers)){
            $receivers = [$receivers];
        }

        if (config('app.sent_mails')) {
            foreach ($receivers as $receiver) {
                if ($receiver->email && !str_contains($receiver->email, 'DN')) {
                    Mail::to($receiver->email)->send((new VacationMail($receiver->name, $params)));
                }
            }
        }
    }
}