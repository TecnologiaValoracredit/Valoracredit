<?php

namespace App\Http\Controllers;
use App\Models\Commission;
use App\Models\SSale;
use App\DataTables\CommissionDataTable;
use App\DataTables\InstitutionCommissionDataTable;
use App\DataTables\SUserNameDataTable;

use App\Exports\Commissions\CommissionExport;
use Maatwebsite\Excel\Facades\Excel;


use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CommissionRequest;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(CommissionDataTable $dataTable)
    {
        //obtener todos los commissions, y permisos registrados
        // $allowExport = auth()->user()->hasPermissions("commissions.exportReport");
        $allowExport = true;
        return $dataTable->render('commissions.index', compact("allowExport"));
    }

    public function exportReport(Request $request)
    { 
        $startDate = $request->input('initial_date'); // Obtener la fecha de inicio desde la solicitud
        $endDate = $request->input('final_date'); // Obtener la fecha de fin desde la solicitud
        // Validar las fechas (opcional)
        $request->validate([
            'initial_date' => 'required|date',
            'final_date' => 'required|date|after_or_equal:initial_date',
        ]);

        $polizaData = $this->getPolizaData($startDate, $endDate);
        $commissionData = $this->getCommissionData($startDate, $endDate);
        $outSourcing = 4;
        $dates = [
            "initial_date" => $startDate,
            "final_date" => $endDate
        ];

        return Excel::download(new CommissionExport($commissionData, $polizaData, $dates, $outSourcing), 'Comisiones-'.$startDate.'-'.$endDate.'.xlsx');
    }

    protected function getCommissionData($startDate, $endDate)
    {
       $data = Commission::selectRaw('
            users.id as user_id,
            users.name as user_name,
            DATE(s_sales.grant_date) as sale_day,
            SUM(commissions.amount_received) as total_commission,
            banks.name as bank_name,
            bank_details.account_number
        ')
        ->leftJoin('s_sales', 'commissions.s_sale_id', '=', 's_sales.id')
        ->leftJoin('users', 'commissions.user_id', '=', 'users.id')
        ->leftJoin('bank_details', 'users.id', '=', 'bank_details.user_id')
        ->leftJoin('banks', 'bank_details.bank_id', '=', 'banks.id')
        ->whereBetween('s_sales.grant_date', [$startDate, $endDate])
        ->groupBy('users.id', 'users.name', 'sale_day', "banks.name", "account_number")
        ->get();
        return $data;
    }

    protected function getPolizaData($startDate, $endDate)
    {
       $data = Commission::selectRaw('
            SUM(commissions.amount_received) as total_commission,
            s_branches.segment,
            s_branches.accounting_account
        ')
        ->leftJoin('s_sales', 'commissions.s_sale_id', '=', 's_sales.id')
        ->leftJoin('s_branches', 's_sales.s_branch_id', '=', 's_branches.id')
        ->whereBetween('s_sales.grant_date', [$startDate, $endDate])
        ->groupBy("segment", "accounting_account")
        ->get();

        return $data;
    }

    public function addInstitution(User $user, Request $request)
    {
        $status = true;
        try {
           $user->institutions()->updateOrCreate(
                ['institution_id' => $request->institution_id], // Campos para buscar
                ['percentage' => $request->percentage,
                        'created_by' =>  auth()->id(),]          // Campos para crear o actualizar
            );
            $message = "Comisión actualizada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'institution_commissions');
        }
        return $this->getResponse($status, $message);
    }

    //Método para elimianr la institución
    public function deleteInstitution(InstitutionCommission $institution_commission)
    {
        $status = true;
        try {
            $institution_commission->delete();
            $message = "Institución eliminada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'institution_commissions');
        }
        return $this->getResponse($status, $message);
    }

    
    public function addName(User $user, Request $request)
    {
        $status = true;
        try {
           $user->sUserNames()->create(
                ['name' => $request->s_user_name], // Campos para buscar
            );
            $message = "Nombre creado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'institution_commissions');
        }
        return $this->getResponse($status, $message);
    }

    //Método para elimianr el nombre
    public function deleteName(SUserName $s_user_name)
    {
        $status = true;
        try {
            $s_user_name->delete();
            $message = "Nombre eliminada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 's_user_names');
        }
        return $this->getResponse($status, $message);
    }

    public function getInstitutionCommissionDataTable(User $user)
    {
        return (new InstitutionCommissionDataTable($user))->render('components.datatable');
    }

    public function getSUserNameDataTable(User $user)
    {
        return (new SUserNameDataTable($user))->render('components.datatable');
    }
}
