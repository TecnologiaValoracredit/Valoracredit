<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FFlux;
use App\Models\FMovementType;
use App\Models\FAccount;
use App\Models\FStatus;
use App\Models\FBeneficiary;

use App\Models\PermissionModule;
use App\DataTables\FFluxDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FFluxRequest;

class FFluxController extends Controller
{
    public function index(FFluxDataTable $dataTable )
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("f_fluxes.create");
        $f_statuses = FStatus::where("is_active", 1)->pluck("name", "id");
        $f_beneficiaries = FBeneficiary::where("is_active", 1)->pluck("name", "id");
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");;
        return $dataTable->render('f_fluxes.index', compact("allowAdd","f_movement_types","f_statuses","f_beneficiaries"));
    }

    public function create()
    {
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");
        $f_accounts = FAccount::where("is_active", 1)->pluck("name", "id");
        $f_statuses = FStatus::where("is_active", 1)->pluck("name", "id");
        return view('f_fluxes.create', compact("f_movement_types", "f_accounts", "f_statuses"));
    }

    public function store(FFluxRequest $request)
    {
        $status = true;
		$f_flux = null;

        $params = array_merge($request->all(), [
            'f_status_id' => 1,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$f_flux = FFlux::create($params);
			$message = "Flujo creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_fluxes');
		}
        return $this->getResponse($status, $message, $f_flux);

    }

    public function edit(FFlux $f_flux)
    {
        $f_movement_types = FMovementType::where("is_active", 1)->pluck("name", "id");
        $f_accounts = FAccount::where("is_active", 1)->pluck("name", "id");
        $f_statuses = FStatus::where("is_active", 1)->pluck("name", "id");

        return view('f_fluxes.edit', compact("f_movement_types", "f_accounts", "f_statuses","f_flux"));
     
    }

    public function update(FFluxRequest $request, FFlux $f_flux)
    {
        $status = true;
        $params = array_merge($request->all(), [
			'name' => $request->name,
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$f_flux->update($params);
			$message = "Flujo modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_fluxes');
		}
        return $this->getResponse($status, $message, $f_flux);

    }

    public function show(FFlux $f_flux)
    {
    }

    public function destroy(FFlux $f_flux)
    {
        $status = true;
        try {
            $f_flux->update(["is_active" => false]);
            $message = "Flujo desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_fluxes');
        }
        return $this->getResponse($status, $message);
    }

    public function changeStats(FFlux $f_flux)
    {
        $status = true;
        try {
            $f_flux->update(["f_status_id" => 2]);
            $message = "Flujo desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_fluxes');
        }
        return $this->getResponse($status, $message);
    }

    public function showExpenses(FFlux $f_movement_types)
    {
        $allowAdd = auth()->user()->hasPermissions("f_fluxes.showExpenses");

        $f_movement_types = FMovementType::where("is_active",1)->where("id",1)->pluck("name","id");

        return $dataTable->render('f_fluxes.index', compact("allowAdd", "f_movement_types", "f_statuses", "f_beneficiaries"));
    }

    

    public function showIncome(FFlux $f_movement_types)
    {
        $allowAdd = auth()->user()->hasPermissions("f_fluxes.showIncome");

        $f_movement_types = FMovementType::where("is_active",0)->where("id",1)->pluck("name","id");
        
        return $dataTable->render('f_fluxes.index', compact("allowAdd","f_movement_types","f_statuses","f_beneficiaries"));
    }

    

}

