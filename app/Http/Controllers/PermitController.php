<?php

namespace App\Http\Controllers;

use App\DataTables\PermitDataTable;
use App\Http\Requests\PermitRequest;
use App\Mail\PermitSentMail;
use App\Mail\PermitDeniedMail;
use App\Mail\PermitApprovedMail;
use App\Models\DiscountCharacteristic;
use App\Models\Permit;
use App\Models\Departament;
use App\Models\User;
use App\Models\Role;
use App\Models\JobPosition;
use App\Models\Motive;
use App\Models\PermitStatus;
use DateTime;
use DateInterval;
use DatePeriod;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailable;

use Illuminate\Support\Facades\Mail;
use function PHPUnit\Framework\isNull;

class PermitController extends Controller
{
    public function index(PermitDataTable $dataTable) {

        $allowAdd = auth()->user()->hasPermissions("permits.create");
        return $dataTable->render('permits.index', compact('allowAdd'));
    }

    public function create() {

        $users = User::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $job_positions = JobPosition::where("is_active", 1)->pluck("name", "id");
        $motives = Motive::all()->pluck("name", "id");
        $discount_characteristics = DiscountCharacteristic::all()->pluck("name", "id");

        return view('permits.create', compact('users', 'departaments', 'job_positions', 'motives', 'discount_characteristics'));
    }

    public function store(PermitRequest $request) {
        $status = true;
        $message = null;
        $permit = null;
        
        try {
            $currentUser = auth()->user();

            $params = array_merge($request->all(), [
                'user_id' => $currentUser->id,
                'departament_id' => $currentUser->departament->id,
                'job_position_id' => $currentUser->jobPosition->id,
                'boss_id' => $currentUser->boss->id ?? null,
    
                'permit_date' => $request->permit_date ?? now()->toDateString(),
                'entry_hour' => $request->entry_hour,
                'exit_hour' => $request->exit_hour,
                'pending_hours' => $request->pending_hours,
    
                'motive_id' => $request->motive_id,
                'discount_characteristic_id' => $request->discount_characteristic_id,
                'user_observations' => $request->user_observations,
    
                'path_user_signature' => $currentUser->signature_path ?? null,
            ]);

            //Si el usuario no cuenta con firma guardada
            if ($currentUser->signature_path == null){
                /** @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
                $fileSystem = Storage::disk('public');
                
                //Decodifica firma para convertirla a PNG.
                //Genera nombre de firma y ruta
                $codedString = str_replace('data:image/png;base64,','',$request->signature_data);
                $signatureFile = base64_decode($codedString);
                $fileName = 'Firma_Usuario_' . $currentUser->id . '.png';
                $path_user_signature = 'signatures/' . $fileName;
                
                //Guarda la ruta
                $fileSystem->put($path_user_signature, $signatureFile);
                
                $params = array_merge($params, [
                    'path_user_signature' => $path_user_signature ?? null,
                ]);
                
                //Si quiere guardar la firma
                if ($request->save_signature){
                    $currentUser->update([
                        'path_signature' => $path_user_signature ?? null,
                    ]);
                }
            }

            $permit = Permit::create($params);
            $message = "Permiso creado correctamente";
            
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'permits');
        }

        return $this->getResponse($status, $message, $permit);
    }

    public function edit(Request $request, Permit $permit) {

        try {
            $this->authorize('edit', $permit);
        } catch (\Throwable $th) {
            return redirect()->route('unauthorized');
        }

        $users = User::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $job_positions = JobPosition::where("is_active", 1)->pluck("name", "id");
        $motives = Motive::all()->pluck("name", "id");
        $discount_characteristics = DiscountCharacteristic::all()->pluck("name", "id");

        return view('permits.edit', compact('users', 'departaments', 'job_positions', 'motives', 'discount_characteristics', 'permit'));
    }

    public function update(PermitRequest $request, Permit $permit) {
        $status = true;
        $message = null;

        $params = array_merge($request->all(), [
            'entry_hour' => $request->entry_hour,
            'exit_hour' => $request->exit_hour,
            'pending_hours' => $request->pending_hours,

            'motive_id' => $request->motive_id,
            'discount_characteristic_id' => $request->discount_characteristic_id,
            'user_observations' => $request->user_observations,
        ]);

        try {
            $permit->update($params);
            $message = "Permiso modificado correctamente";

        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'permits');
        }

        return $this->getResponse($status, $message, $permit);
    }

    public function show(Permit $permit) {
        return view('permits.show', compact('permit'));
    }

    public function destroy(Permit $permit) {
        $status = true;
        $message = null;

        if (!in_array($permit->permitStatus->name, ["Creado", "Enviado", "En revisión"])){
            $status = false;
            $message = "No se puede eliminar un permiso ya aprobado/denegado";

            return abort(422, $message);
        }

        $cancelledStatus = PermitStatus::where('name', 'Cancelado')->first();

        try {
            $permit->update([
                'is_active' => false,
                'permit_status_id' => $cancelledStatus->id,
            ]);
            $message = "Permiso eliminado correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'permits');
        }

        return $this->getResponse($status, $message, $permit);
    }

    public function sendPermit(PermitRequest $request, Permit $permit){
        $status = true;
        $message = null;
        $sentStatus = PermitStatus::where('name', 'Enviado')->first();
        
        if ($permit->permitStatus->name != "Creado"){
            $status = false;
            $message = "No se puede mandar un permiso previamente mandado";

            return abort(422, $message);
        }

        try {
            $params = [
                'permit_status_id' => $sentStatus->id,
            ];

            $permit->update($params);
            $message = "Permiso enviado correctamente";
            
            $this->sendPermitSentMail($permit);
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'permits');
        }

        return $this->getResponse($status, $message, $permit);
    }

    public function changePermitStatus(Permit $permit){

        try {
            $this->authorize('changePermitStatus', $permit);
        } catch (\Throwable $th) {
            return redirect()->route('unauthorized');
        }

        $isHr = auth()->user()->hasPermissions('permits.seeAllPermits');
        $isBothHrAndBoss = $isHr && !$permit->boss || $isHr && $permit->boss_id == auth()->id();

        $userObservations = $isHr ? 'hr_observations' : 'boss_observations';
        $userSignature = $isBothHrAndBoss ? 'RH y Jefe Inmediato' : ($isHr ? 'RH' : 'Jefe Directo');

        $underReviewStatus = PermitStatus::where('name', 'En revisión')->first();

        if ($permit->permitStatus->name != "En revisión"){
            $permit->update([
                'permit_status_id' => $underReviewStatus->id,
            ]);
        }

        return view('permits.changePermitStatus', compact('permit', 'userSignature', 'userObservations'));
    }

    public function sign(PermitRequest $request, Permit $permit){
        $status = true;
        $message = null;

        //Detecta si es RH al contar con los permisos
        $isHr = auth()->user()->hasPermissions('permits.seeAllPermits');
        //Los permisos pueden tener referencias a jefes de usuario nulas, pero nunca puede haber un usuario que no sea RH
        //Ya sea que RH sea su propio jefe, o que un solicitante sea jefe, esta condicion detecta si se firmara como ambos, RH y Jefe
        //Detecta tambien si RH es jefe del solicitante
        $isBothHrAndBoss = $isHr && !$permit->boss || $isHr && $permit->boss_id == auth()->id();

        $signature = 'is_signed_by_'. ($isHr ? 'hr' : 'boss');
        $observations = ($isHr ? 'hr' : 'boss') . '_observations';
        $path = 'path_' . ($isHr ? 'hr' : 'boss') . '_signature';

        $params = null;
        $currentUser = auth()->user();

        if ($isBothHrAndBoss){
            $params = array_merge($request->all(), [
                'hr_id' => $currentUser->id,
                'hr_observations' => $request->hr_observations,
                'boss_observations' => 'Firmado como RH y Jefe Inmediato',
                'is_signed_by_hr' => true,
                'is_signed_by_boss' => true,
                'path_hr_signature' => $currentUser->path_signature ?? null,
                'path_boss_signature' => $currentUser->path_signature ?? null,
            ]);
        }
        else{
            $params = array_merge($request->all(), [
                'hr_id' => $isHr ? $currentUser->id : null,
                $observations => $request->$observations,
                $signature => true,
                $path => $currentUser->path_signature ?? null,
            ]);
        }

        //Si no se cuenta con firma guardada
        if ($currentUser->path_signature == null){
            /** @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
            $fileSystem = Storage::disk('public');
    
            $codedString = str_replace('data:image/png;base64,','',$request->signature_data);
            $signatureFile = base64_decode($codedString);
            $fileName = 'Firma_Usuario_' . $currentUser->id . '.png';
            $pathValue = 'signatures/' . $fileName;

            $fileSystem->put($pathValue, $signatureFile);

            //Se crean dos variables separadas de path y pathValue, ya que en path, si no es RH y Jefe al mismo tiempo, define que path es.

            if ($isBothHrAndBoss){                
                $params = array_merge($params, [
                    'path_hr_signature' => $pathValue,
                    'path_boss_signature' => $pathValue,
                ]);
            }
            else{
                $params = array_merge($params, [
                    $path => $pathValue,
                ]);
            }

            if ($request->save_signature){
                $currentUser->update([
                    'path_signature' => $pathValue,
                ]);
            }
        }

        try {
            $permit->update($params);
            $message = "El permiso ha sido firmado correctamente por ". ($isHr ? "Recursos Humanos" : "Jefe Inmediato");

            $this->checkForApprovable($permit);

        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'permits');
        }

        return $this->getResponse($status, $message, $permit);
    }

    public function deny(PermitRequest $request, Permit $permit){
        $status = true;
        $message = null;
        $isHr = auth()->user()->hasPermissions('permits.seeAllPermits');

        $deniedStatus = PermitStatus::where('name', 'Denegado')->first();
        $observations = ($isHr ? 'hr' : 'boss') . '_observations';

        try {
            $params = array_merge($request->all(), [
                $observations => $request->$observations,
                'is_signed_by_hr' => false,
                'is_signed_by_boss' => false,
                'permit_status_id' => $deniedStatus->id,
            ]);

            $permit->update($params);
            $message = "El permiso ha sido denegado correctamente por ". ($isHr ? "Recursos Humanos" : "Jefe Inmediato");
            
            $this->sendDeniedMail($permit);
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'permits');
        }

        return $this->getResponse($status, $message, $permit);
    }

    private function checkForApprovable(Permit $permit){
        if (!$permit->is_signed_by_hr || !$permit->is_signed_by_boss) return;
        
        $approvedStatus = PermitStatus::where('name', 'Aprobado')->first();

        $permit->update([
            'permit_status_id' => $approvedStatus->id,
        ]);

        $this->sendApprovedMail($permit);
    }

    public function exportPermit(Permit $permit){
        $pdf = Pdf::loadView('permits.pdf.permit', [
            'permit' => $permit,
        ])->setPaper('letter', 'portrait');

        return $pdf->download('Permiso_'.$permit->id.'_.pdf');
    }

    //MAILS
    public function sendPermitSentMail(Permit $permit){
        $hrRole = Role::where('name', 'Recursos Humanos')->first();
        $hrUser = User::where('role_id', $hrRole->id)->first();

        $receivers = [
            $hrUser,
            $permit->boss,
        ];

        foreach ($receivers as $receiver) {
            if (!$receiver || !$receiver->email) continue;
            if (!str_contains('DN', $receiver->email)){
                Mail::send(new PermitSentMail( $receiver,$permit));
            }
        }
    }

    public function sendApprovedMail(Permit $permit){
        $receiver = $permit->user;

        if ($receiver->email && !str_contains($receiver->email, 'DN')) {
            Mail::send(new PermitApprovedMail($receiver, $permit));
        }
    }
    public function sendDeniedMail(Permit $permit){
        $receiver = $permit->user;

        if ($receiver->email && !str_contains($receiver->email, 'DN')){
            Mail::send(new PermitDeniedMail($receiver, $permit));
        }
    }
}
