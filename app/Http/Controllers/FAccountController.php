<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FAccount;
use App\Models\PermissionModule;
use App\DataTables\FAccountDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FAccountRequest;

class FAccountController extends Controller
{
    public function index(FAccountDataTable $dataTable)
    {
        //obtener todos los suppliers, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("f_accounts.create");
        return $dataTable->render('f_accounts.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('f_accounts.create');
    }

    public function store(FAccountRequest $request)
    {
        $status = true;
		$f_account = null;

        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$f_account = FAccount::create($params);
			$message = "Cuenta creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_accounts');
		}
        return $this->getResponse($status, $message, $f_account);

    }

    public function edit(FAccount $f_account)
    {
        return view('f_accounts.edit', compact("f_account"));
    }

    public function update(FAccountRequest $request, FAccount $f_account)
    {
        $status = true;
        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
		]);

		try {
			$f_account->update($params);
			$message = "Cuenta modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'f_accounts');
		}
        return $this->getResponse($status, $message, $f_account);

    }

    public function show(FAccount $f_account)
    {
    }

    public function destroy(FAccount $f_account)
    {
        $status = true;
        try {
            $f_account->update(["is_active" => false]);
            $message = "Cuenta desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'f_accounts');
        }
        return $this->getResponse($status, $message);
    }


}

