<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\InstitutionCommissionDataTable;
use App\DataTables\SUserNameDataTable;

use App\Models\User;
use App\Models\InstitutionCommission;
use App\Models\SUserName;

class CommissionController extends Controller
{
    public function index()
    {
        
    }

    public function addInstitution(User $user, Request $request)
    {
        $status = true;
        try {
           $user->institutions()->updateOrCreate(
                ['institution_id' => $request->institution_id], // Campos para buscar
                ['percentage' => $request->percentage]          // Campos para crear o actualizar
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
