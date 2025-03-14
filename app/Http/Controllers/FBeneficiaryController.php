<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FBeneficiary;
use App\Models\PermissionModule;
use App\DataTables\FBeneficiaryDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FBeneficiaryRequest;
use Illuminate\Support\Facades\DB;

class FBeneficiaryController extends Controller
{
    public function index(FBeneficiaryDataTable $dataTable)
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("f_beneficiaries.create");
        return $dataTable->render('f_beneficiaries.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('f_beneficiaries.create');
    }

    public function store(FBeneficiaryRequest $request)
    {
        $status = true;
		$f_beneficiary = null;

        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
		]);
        //Verificar si ya existe el beneficiario
        $f_beneficiary = FBeneficiary::where("name", trim($params["name"]))->where("is_active", 1)->first();
       
		try {
            $message = "Beneficiario creado correctamente";
            if ($f_beneficiary == null) {
                $f_beneficiary = FBeneficiary::create($params);
            }else {
                $message = "El beneficiario ya existe";
                $status = false;
            }
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_beneficiaries');
		}
        return $this->getResponse($status, $message, $f_beneficiary);

    }

    public function edit(FBeneficiary $f_beneficiary)
    {
        return view('f_beneficiaries.edit', compact("f_beneficiary"));
    }

    public function update(FBeneficiaryRequest $request, FBeneficiary $f_beneficiary)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
		]);
        //Verificar si ya existe el beneficiario
        $f_beneficiary_exist = FBeneficiary::where("name", trim($params["name"]))->where("is_active", 1)->first();
		try {
            $message = "Beneficiario modificado correctamente";
            if ($f_beneficiary_exist == null) {
                $f_beneficiary->update($params);
            }else {
                $message = "El beneficiario ya existe";
                $status = false;
            }
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_beneficiaries');
		}
        return $this->getResponse($status, $message, $f_beneficiary);

    }

    public function show(FBeneficiary $f_beneficiary)
    {
    }

    public function destroy(FBeneficiary $f_beneficiary)
    {
        $status = true;
        try {
            $f_beneficiary->update(["is_active" => false]);
            $message = "Beneficiario desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_beneficiaries');
        }
        return $this->getResponse($status, $message);
    }

    public function getAddModal()
    {
        $type = "add";
        return view("f_beneficiaries.modal-content", compact("type"));
    }

    public function getDataAutocomplete()
    {
        $f_beneficiaries = FBeneficiary::select(
            "id",
            DB::raw("f_beneficiaries.name as name")
        )->get();

        $formattedBeneficiaries = $f_beneficiaries->map(function ($f_beneficiary) {
            return [
                'id' => $f_beneficiary->id,
                'name' => $f_beneficiary->name
            ];
        });

        return response()->json($formattedBeneficiaries);    
    }


}

