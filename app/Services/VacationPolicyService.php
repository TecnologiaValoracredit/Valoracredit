<?php

namespace App\Services;

use App\Models\VacationPolicy;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class VacationPolicyService {
    public function __construct() {

    }

    public function store(Request $request){
        $status = true;
        $error = null;

        $requestInputs = [
            'years_from' => $request->input('years_from'),
            'years_to' => $request->input('years_to'),
            'days' => $request->input('days'),
            'advance_days' => $request->input('advance_days'),
            'applicable_month_range' => $request->input('applicable_month_range'),
        ];

        try {
            $this->createVacationPolicy($requestInputs);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [ $status, $error ];
    }
    public function update(Request $request, VacationPolicy $vacationPolicy){
        $status = true;
        $error = null;

        $requestInputs = [
            'years_from' => $request->input('years_from'),
            'years_to' => $request->input('years_to'),
            'days' => $request->input('days'),
            'advance_days' => $request->input('advance_days'),
            'applicable_month_range' => $request->input('applicable_month_range'),
        ];

        try {
            $this->updateVacationPolicy($vacationPolicy, $requestInputs);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [ $status, $error ];
    }
    public function destroy(VacationPolicy $vacationPolicy ){
        $status = true;
        $error = null;

        try {
            $this->deleteVacationPolicy($vacationPolicy);
        } catch (\Throwable $th) {
            $status = false;
            $error = $th;
        }

        return [$status, $error];
    }

    //HELPERS

    public function createVacationPolicy($requestInputs) {
        try {
            VacationPolicy::create($requestInputs);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    public function updateVacationPolicy(VacationPolicy $vacationPolicy, $requestInputs) {
        try {
            $vacationPolicy->update([
                'years_from' => $requestInputs['years_from'],
                'years_to' => $requestInputs['years_to'],
                'days' => $requestInputs['days'],
                'advance_days' => $requestInputs['advance_days'],
                'applicable_month_range' => $requestInputs['applicable_month_range'],
            ]);
        } catch (QueryException $e) {
            throw $e;
        }
    }

    public function deleteVacationPolicy(VacationPolicy $vacationPolicy) {
        try {
            $vacationPolicy->update([
                'is_active' => false,
            ]);
        } catch (QueryException $e) {
            throw $e;
        }
    }
}