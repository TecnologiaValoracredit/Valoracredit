<?php

namespace App\Http\Controllers;

use App\DataTables\BankDetailDataTable;
use App\Models\BankDetail;
use App\Models\CivilStatus;
use App\Models\ContractType;
use App\Models\Contract;

use App\Models\Gender;
use App\Models\JobPosition;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\Role;
use App\Models\Branch;
use App\Models\Bank;
use App\Models\Departament;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\Email;
use Webklex\PHPIMAP\ClientManager;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("users.create");
        return $dataTable->render('users.index', compact("allowAdd"));
    }

    // Mostrar formulario de cambio de contraseña
    public function changePassword(User $user)
    {
        return view('users.changePassword', compact('user'));
    }

    public function setNewPassword(Request $request, User $user)
    {
        // Verificar que el usuario autenticado sea el mismo
        if (auth()->id() !== $user->id) {
            abort(403, 'No tienes permiso para cambiar la contraseña de este usuario.');
        }

        // Validar las contraseñas
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed|min:8',
        ]);
        

        // Verificar si la contraseña actual es correcta
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Cambiar la contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('dashboard.index')->with('success', 'Contraseña cambiada exitosamente.');
    }

    

    public function create()
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $banks = Bank::where("is_active", 1)->pluck("name", "id");
        $job_positions = JobPosition::where("is_active", 1)->pluck("name", "id");
        $users = User::where("is_active", 1)->pluck("name", "id");

        $genders = Gender::all()->pluck('name', 'id');
        $civilStatuses = CivilStatus::all()->pluck('name', 'id');
        $contracts = Contract::with('contractType')
        ->get()
        ->mapWithKeys(function ($contract) {

            $duration = $contract->contractType->duration;

            // Si es -1 → Indeterminado
            $durationText = ($duration == -1)
                ? 'Indeterminado'
                : $duration . ' días';

            return [
                $contract->id => $contract->name . ' - ' . $durationText,
            ];
        });

        return view('users.create', compact('roles', 'branches', 'departaments', 'banks', 'job_positions', 'users', 'genders', 'civilStatuses'));
    }

    public function store(Request $request)
    {
        $status = true;
        $user = null;

        //Create user
        try {
            $params = array_merge($request->all(), [
                'path_ine' => null,
                'path_curp' => null,
                'path_address' => null,
                'path_birth_document' => null,
                'path_account_status' => null,
                'path_rfc' => null,
                'path_nss' => null,

                "password" => Hash::make($request->password),
                'is_active' => !is_null($request->is_active),
            ]);

            $user = User::create($params);

            //Store files
            /** @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
            $fileSystem = Storage::disk('public');

            if($request->file('ine_file')){
                $ineFile = $request->file('ine_file');
                $ineFileExtension = '.' . $ineFile->getClientOriginalExtension();
                $ineFileName = $user->id. '_' . 'INE' . $ineFileExtension;
                $fileSystem->putFileAs('ines', $ineFile, $ineFileName);
            }
            if($request->file('curp_file')){
                $curpFile = $request->file('curp_file');
                $curpFileExtension = $curpFile->getClientOriginalExtension();
                $curpFileName = $user->id . '_' . 'CURP' . $curpFileExtension;
                $fileSystem->putFileAs('curps', $curpFile, $curpFileName);
            }
            if($request->file('address_file')){
                $addressFile = $request->file('address_file');
                $addressFileExtension = $addressFile->getClientOriginalExtension();
                $addressFileName = $user->id . '_' . 'ADDRESS' . $addressFileExtension;
                $fileSystem->putFileAs('addresses', $addressFile, $addressFileName);
            }
            if($request->file('birth_document_file')){
                $birthFile = $request->file('birth_document_file');
                $birthFileExtension = $birthFile->getClientOriginalExtension();
                $birthFileName = $user->id . '_' . 'BIRTH_DOCUMENT' . $birthFileExtension;
                $fileSystem->putFileAs('birth_docs', $birthFile, $birthFileName);
            }
            if($request->file('account_status_file')){
                $accountFile = $request->file('account_status_file');
                $accountFileExtension = $accountFile->getClientOriginalExtension();
                $accountFileName = $user->id . '_' . 'ACCOUNT_STATUS' . $accountFileExtension;
                $fileSystem->putFileAs('accounts', $accountFile, $accountFileName);
            }
            if($request->file('rfc_file')){
                $rfcFile = $request->file('rfc_file');
                $rfcFileExtension = $rfcFile->getClientOriginalExtension();
                $rfcFileName = $user->id . '_' . 'RFC' . $rfcFileExtension;
                $fileSystem->putFileAs('rfcs', $rfcFile, $rfcFileName);
            }
            if($request->file('nss_file')){
                $nssFile = $request->file('nss_file');
                $nssFileExtension = $nssFile->getClientOriginalExtension();
                $nssFileName = $user->id . '_' . 'NSS' . $nssFileExtension;
                $fileSystem->putFileAs('nsss', $nssFile, $nssFileName);
            }

            //Update User´s paths IF not null
            $pathParams = [
                'path_ine' => $ineFileName ?? null,
                'path_curp' => $curpFileName ?? null,
                'path_address' => $addressFileName ?? null,
                'path_birth_document' => $birthFileName ?? null,
                'path_account_status' => $accountFileName ?? null,
                'path_rfc' => $rfcFileName ?? null,
                'path_nss' => $nssFileName ?? null,
            ];

            try {
                $user->update($pathParams);
                $message = "Usuario creado correctamente";
            } catch (QueryException $e) {
                $status = false;
                $message = $this->getErrorMessage($e, 'users');
            }

        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'roles');
        }

        return $this->getResponse($status, $message, $user);
    }

    public function edit(User $user)
    {
        $roles = Role::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $banks = Bank::where("is_active", 1)->pluck("name", "id");
        $job_positions = JobPosition::where("departament_id", $user->departament_id)->pluck("name", "id");
        $users = User::where("is_active", 1)->pluck("name", "id");
        $genders = Gender::all()->pluck('name', 'id');
        $civilStatuses = CivilStatus::all()->pluck('name', 'id');
        $contracts = Contract::with('contractType')
        ->get()
        ->mapWithKeys(function ($contract) {

            $duration = $contract->contractType->duration;

            // Si es -1 → Indeterminado
            $durationText = ($duration == -1)
                ? 'Indeterminado'
                : $duration . ' días';

            return [
                $contract->id => $contract->name . ' - ' . $durationText,
            ];
        });

        return view('users.edit', compact('roles', 'user', 'branches', 'departaments', 'banks', 'job_positions', 'users', 'genders', 'civilStatuses', 'contracts'));

    }

    public function update(UserRequest $request, User $user)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "email" => $request->email,
            "role_id" => $request->role_id,
            'is_active' => !is_null($request->is_active),
        ]);

        unset($params["password"]);
        if ($request->password) {
            $params["password"] = Hash::make($request->password);
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
        $fileSystem = Storage::disk('public');

        unset($params["ine_file"]);
        if($request->file('ine_file')){
            $ineFile = $request->file('ine_file');
            $ineFileExtension = '.' . $ineFile->getClientOriginalExtension();
            $ineFileName = $user->id. '_' . 'INE' . $ineFileExtension;
            $fileSystem->putFileAs('ines', $ineFile, $ineFileName);
            $params["path_ine"] = $ineFileName;
        }

        unset($params["curp_file"]);
        if($request->file('curp_file')){
            $curpFile = $request->file('curp_file');
            $curpFileExtension = '.' . $curpFile->getClientOriginalExtension();
            $curpFileName = $user->id . '_' . 'CURP' . $curpFileExtension;
            $fileSystem->putFileAs('curps', $curpFile, $curpFileName);
            $params["path_curp"] = $curpFileName;
        }

        unset($params["address_file"]);
        if($request->file('address_file')){
            $addressFile = $request->file('address_file');
            $addressFileExtension = '.' . $addressFile->getClientOriginalExtension();
            $addressFileName = $user->id . '_' . 'ADDRESS' . $addressFileExtension;
            $fileSystem->putFileAs('addresses', $addressFile, $addressFileName);
            $params["path_address"] = $addressFileName;
        }

        unset($params["birth_document_file"]);
        if($request->file('birth_document_file')){
            $birthFile = $request->file('birth_document_file');
            $birthFileExtension = '.' . $birthFile->getClientOriginalExtension();
            $birthFileName = $user->id . '_' . 'BIRTH_DOCUMENT' . $birthFileExtension;
            $fileSystem->putFileAs('birth_docs', $birthFile, $birthFileName);
            $params["path_birth_document"] = $birthFileName;
        }

        unset($params["account_status_file"]);
        if($request->file('account_status_file')){
            $accountFile = $request->file('account_status_file');
            $accountFileExtension = '.' . $accountFile->getClientOriginalExtension();
            $accountFileName = $user->id . '_' . 'ACCOUNT_STATUS' . $accountFileExtension;
            $fileSystem->putFileAs('accounts', $accountFile, $accountFileName);
            $params["path_account_status"] = $accountFileName;
        }

        unset($params["rfc_file"]);
        if($request->file('rfc_file')){
            $rfcFile = $request->file('rfc_file');
            $rfcFileExtension = '.' . $rfcFile->getClientOriginalExtension();
            $rfcFileName = $user->id . '_' . 'RFC' . $rfcFileExtension;
            $fileSystem->putFileAs('rfcs', $rfcFile, $rfcFileName);
            $params["path_rfc"] = $rfcFileName;
        }

        unset($params["nss_file"]);
        if($request->file('nss_file')){
            $nssFile = $request->file('nss_file');
            $nssFileExtension = '.' . $nssFile->getClientOriginalExtension();
            $nssFileName = $user->id . '_' . 'NSS' . $nssFileExtension;
            $fileSystem->putFileAs('nsss', $nssFile, $nssFileName);
            $params["path_nss"] = $nssFileName;
        }

        try {
            $user->update($params);
            if ($user->is_active) {
                $user->activate();
            }

            $message = "Usuario modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'users');
        }

        return $this->getResponse($status, $message, $user);
    }

    public function destroy(User $user)
    {
        $status = true;
        try {
            $user->update(["is_active" => false]);
            $user->deactivate();

            $message = "Usuario desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'users');
        }
        return $this->getResponse($status, $message);
    }

    public function addBankDetail(User $user, Request $request)
    {
        $status = true;
        try {
           $user->bankDetails()->create(
                [
                    'bank_id' => $request->bank_id,
                    "account_number" => $request->account_number
                ], // Campos para buscar
            );
            $message = "Detalle bancario creado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'bank_details');
        }
        return $this->getResponse($status, $message);
    }

    //Método para elimianr el nombre
    public function deleteBankDetail(BankDetail $bankDetail)
    {
        $status = true;
        try {
            $bankDetail->delete();
            $message = "Detalle bancario eliminado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'bank_details');
        }
        return $this->getResponse($status, $message);
    }

    public function getBankDetailDataTable(User $user)
    {
        return (new BankDetailDataTable($user))->render('components.datatable');
    }
    
    public function deleteSavedFile(User $user, Request $request){
        $status = false;

        try {
            $params = [
                $request->filePath => null, 
            ];

            $user->update($params);
            $message = "Archivo eliminado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'users');
        }

        return $this->getResponse($status, $message);
    }

}
