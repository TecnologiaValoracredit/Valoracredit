<?php

namespace App\Services;

use App\Enums\RequisitionApprovalDecisionEnum;
use App\Enums\RequisitionGlobalStatusEnum;
use App\Enums\RequisitionOwnerPermissionEnum;
use App\Models\RequisitionGlobal;
use App\Models\RequisitionApproval;
use App\Models\RequisitionStatus;
use App\Models\RequisitionGlobalStatus;
use App\Models\RequisitionLog;
use App\Models\Requisition;
use App\Models\User;
use App\Models\Role;
use App\Enums\RequisitionStatusEnum;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\RequisitionGlobalMail;

class RequisitionGlobalService
{
    public function __construct()
    {

    }

    public function store(Request $request){
        $status = true;
        $error = null;
        $globalRequisition = null;

        $ids = collect($request->all())
            ->filter(fn ($value, $key) => str_contains($key, 'req-'))
            ->map(fn ($value, $key) => (int) str_replace('req-', '', $key))
            ->values()
            ->all();

        if(count($ids) == 0){
            $status = false;
            $error = "Se deben elegir requisiciones para crear una global.";

            return [$status, $error, null];
        }

        try {
            $status = RequisitionGlobalStatus::where('name', RequisitionGlobalStatusEnum::CREATED->value)->first();
            $globalRequisition = RequisitionGlobal::create([
                'created_by' => auth()->id(),
                'is_active' => true,
                'application_date' => $request->application_date,
                'requisition_global_status_id' => $status->id,
            ]);
            
            $nextOwnerPermission = RequisitionOwnerPermissionEnum::GLOBALS;
            //Asigna ID y status global a las requisiciones
            foreach ($ids as $key => $value) {
                $req = Requisition::where('id', $value)->first();
                $req->update([
                    'requisition_global_id' => $globalRequisition->id,
                    'current_owner_permission' => $nextOwnerPermission->value,
                ]);

                $this->createLog($req, RequisitionStatusEnum::GLOBAL_REVIEW, "Seleccionada para Global");
            }
            
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error, $globalRequisition];
    }

    public function update(Request $request, RequisitionGlobal $requisition_global){
        $status = true;
        $error = null;
        
        $requisitionIds = collect($request->all())
            ->filter(fn ($value, $key) => str_contains($key, 'req-'))
            ->map(fn ($value, $key) => (int) str_replace('req-', '', $key))
            ->values()
            ->all();
        
        if(count($requisitionIds) == 0){
            $status = false;
            $error = "No se puede dejar una requisición global sin requisiciones.";
            
            return [$status, $error];
        }

        $nextOwnerPermission = RequisitionOwnerPermissionEnum::GLOBALS;
        $this->deleteNonExistentRequisitions($requisitionIds, $requisition_global);

        try {
            $requisition_global->update([
                'application_date' => $request->application_date,
            ]);

            foreach ($requisitionIds as $key => $id) {
                $req = Requisition::where('id', $id)->first();

                // Agrega nuevas requisiciones a la global
                if ($req->requisition_global_id != $requisition_global->id){
                    $req->update([
                        'requisition_global_id' => $requisition_global->id,
                        'current_owner_permission' => $nextOwnerPermission->value,
                    ]);

                $this->createLog($req, RequisitionStatusEnum::GLOBAL_REVIEW, "Seleccionada para Global");
                }

                //Si ya ha sido aprobada / regresada por Contabilidad o Administración, se anulan sus revisiones anteriores para tomar nuevas
                if ($req->reviewedByRole('Contabilidad') || $req->reviewedByRole('Administración')){
                    $req->invalidPreviousDecisions();
                }
            }

            if ($requisition_global->requisitionGlobalStatus->name == RequisitionGlobalStatusEnum::REVIEWED->value){
                $nextStatus = RequisitionGlobalStatus::where('name', RequisitionGlobalStatusEnum::MODIFIED->value)->first();    
            
                $requisition_global->update([
                    'requisition_global_status_id' => $nextStatus->id,
                ]);
            }

        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error];
    }

    public function destroy(Request $request, RequisitionGlobal $requisition_global){
        $status = true;    
        $error = null;    

        try {
            $requisition_global->update([
                'is_active' => false,
            ]);
            
            //Todas las requisiciones que pertenecían, vuelven a su estado de en espera.
            $reqs = $requisition_global->requisitions;
            foreach ($reqs as $key => $req) {
                $this->createLog($req, RequisitionStatusEnum::STAND_BY_TREASURY, "En espera para Global");
            }
        } catch (QueryException $e) {
            $error = $e;
        }

        return [$status, $error];
    }

    public function updateStatus(Request $request, RequisitionGlobal $requisition_global){
        $status = true;
        $error = null;

        //Filtra y obtiene los IDs de las requisiciones aprobadas
        $requisitionIds = collect($request->all())
            ->filter(fn ($value, $key) => preg_match('/^req-\d+$/', $key)) //Se asegura de agarrar solamente las keys que empiecen con 'req-'
            ->map(fn ($value, $key) => (int) str_replace('req-', '', $key))
            ->values()
            ->all();

        //Obtiene los IDs de las requisiciones guardadas previamente
        $existingReqs = $requisition_global->requisitions;        
        
        try {
            $nextOwnerPermission = RequisitionOwnerPermissionEnum::TREASURY;
            
            foreach ($existingReqs as $key => $req) {
                $notes = $request->input("req-{$req->id}-notes");

                //Si la requisición ya habia sido aprobada por Administracion y Contabilidad O habia sido firmada por admin, la omite
                if (($req->roleApprovedApproval('Contabilidad') && $req->roleApprovedApproval('Administración')) || $req->adminSignatureApproval()){
                    continue;
                }

                //Regresa la requisición si no fue aprobada
                if (!in_array($req->id, $requisitionIds)){
                    $req->update([
                        'requisition_global_id' => null,
                        'current_owner_permission' => $nextOwnerPermission->value,
                    ]);

                    //Si no se ha devuelto por Contabilidad o Administracion, crea un registro de devolucion, para evitar doble registro de su devolución
                    if (!($req->roleReturnedApproval('Contabilidad') || $req->roleReturnedApproval('Administración'))){
                        $this->createApproval($requisition_global, $req, RequisitionApprovalDecisionEnum::RETURNED, $notes);
                        $this->createLog($req, RequisitionStatusEnum::RETURNED_BY_GLOBAL_REVIEW, "Devuelta de Global");
                    }

                    continue;
                }
                
                //Si el usuario tiene permiso para firmar como administrador O si Contabilidad O Administración ya habian aprobado antes, se alista para D.G.
                if (auth()->user()->hasPermissions('requisition_globals.adminSignature') || ($req->roleApprovedApproval('Contabilidad') || $req->roleApprovedApproval('Administración'))){
                    $status = RequisitionGlobalStatus::where('name', RequisitionGlobalStatusEnum::REVIEWED->value)->first();
                    $req->update([
                        'current_owner_permission' => $nextOwnerPermission->value,
                    ]);
                    
                    $requisition_global->update([
                        'requisition_global_status_id' => $status->id,
                    ]);

                    if (auth()->user()->hasPermissions('requisition_globals.adminSignature')){
                        $notes = "Firmada como ambos Administración y Contabilidad";
                    }

                    $this->createApproval($requisition_global, $req, RequisitionApprovalDecisionEnum::APPROVED, $notes);
                    $this->createLog($req, RequisitionStatusEnum::READY_FOR_DG, "Aprobada y lista para D.G.");
                }
                //Si solamente aprueba uno de los dos
                else{
                    $this->createApproval($requisition_global, $req, RequisitionApprovalDecisionEnum::APPROVED, $notes);
                }

            }

            $requisition_global->refresh();
            //Si la global se queda sin requisiciones, la deja como revisada para poder editarla y meter nuevas
            if ($requisition_global->requisitions->isEmpty()){
                $status = RequisitionGlobalStatus::where('name', RequisitionGlobalStatusEnum::REVIEWED->value)->first();

                $requisition_global->update([
                    'requisition_global_status_id' => $status->id,
                ]);

            }
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error];
    }

    public function changeStatus(RequisitionGlobal $requisition_global){
        if ($requisition_global->requisitionGlobalStatus->name == RequisitionGlobalStatusEnum::SENT_TO_ADMIN_AND_ACCOUNT->value){
            $status = RequisitionGlobalStatus::where('name', RequisitionGlobalStatusEnum::UNDER_REVIEW->value)->first();
            $requisition_global->update([
                'requisition_global_status_id' => $status->id,
            ]);
        }
    }

    public function review(RequisitionGlobal $requisition_global){
        foreach ($requisition_global->requisitions as $key => $req) {
            $lastStatusName = $req->lastLog->toStatusId->name;
            if ($lastStatusName != RequisitionStatusEnum::SENT_TO_DG->value) return;
            $this->createLog($req, RequisitionStatusEnum::UNDER_REVIEW_BY_DG, "En revisión de D.G.");
        }
    }

    public function send(Request $request, RequisitionGlobal $requisition_global){
        $status = true;
        $error = null;
        
        $nextStatusEnum = null;
        switch ($requisition_global->requisitionGlobalStatus->name) {
            //MODIFICADA O APENAS CREADA, MANDA A ADMINISTRACIÓN Y CONTABILIDAD
            case RequisitionGlobalStatusEnum::MODIFIED->value:
            case RequisitionGlobalStatusEnum::CREATED->value:
                $nextStatusEnum = RequisitionGlobalStatusEnum::SENT_TO_ADMIN_AND_ACCOUNT;

                //DEFINE A LOS USUARIOS DE CONTABILIDAD Y ADMINISTRACIÓN COMO DESTINATARIOS
                $administrationRole = Role::where('name', 'Administración')->first();
                $accountingRole = Role::where('name', 'Contabilidad')->first();
                $receivers = User::whereIn('role_id', [$administrationRole->id, $accountingRole->id])->get()->all();
                
                $params = [
                    'subject' => 'Requisición global en revisión',
                    'title' => "Requisición global enviada a revisión - {$requisition_global->id}",
                    'message' => 'Se ha enviado una requisición global al área de Administración y Contabilidad para su revisión.',
                    'url' => route('requisition_globals.changeStatus', $requisition_global->id),
                ];
                $this->sendMail($receivers, $params);
                break;
                
            case RequisitionGlobalStatusEnum::REVIEWED->value:
                $nextStatusEnum = RequisitionGlobalStatusEnum::SENT_TO_DG;
                
                //DEFINE COMO DESTINATARIO AL USUARIO DE DIRECCIÓN GENERAL
                $dgRole = Role::where('name', 'Dirección general')->first();
                $receivers = User::where('role_id', $dgRole->id)->first();

                $params = [
                    'subject' => 'Requisición global pendiente de autorización',
                    'title' => "Requisición global enviada a Dirección General - {$requisition_global->id}",
                    'message' => 'Una requisición global ha sido enviada a Dirección General para su autorización.
                                Solicitamos revisar los detalles y emitir una resolución a través del sistema.',
                    'url' => route('requisition_globals.review', $requisition_global->id),
                ];
                $this->sendMail($receivers, $params);
                break;
            
            default:
                $status = false;
                $error = "No se puede mandar una requisición global ya enviada";
                return [$status, $error];
        }

        try {
            $nextStatus = RequisitionGlobalStatus::where('name', $nextStatusEnum->value)->first();
            $requisition_global->update([
                'requisition_global_status_id' => $nextStatus->id,
            ]);

            //SI SE ENVIÓ A DG, SE ACTUALIZA EL ESTATUS DE TODAS LAS REQUISICIONES APROBADAS Y PONE SUS CUENTAS ASIGNADAS
            if ($nextStatusEnum == RequisitionGlobalStatusEnum::SENT_TO_DG){
                foreach ($requisition_global->requisitions as $key => $req) {
                    $bank_id = $request->input("req-{$req->id}-bank_id");
                    $req->update([
                        'current_owner_permission' => RequisitionOwnerPermissionEnum::DG->value,
                        'bank_id' => $bank_id ?? null,
                    ]);

                    $this->createLog($req, RequisitionStatusEnum::SENT_TO_DG, "Enviada a D.G. para revisión.");
                }
            }
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error];
    }

    public function approve(Request $request, RequisitionGlobal $requisition_global){
        $status = true;
        $error = null;

        try {
            $allDecided = true;
            foreach ($requisition_global->requisitions as $key => $req) {
                //Si ya habia sido aprobada, se omite
                if ($req->roleApprovedApproval('Dirección general')){
                    continue;
                }

                $decision = RequisitionApprovalDecisionEnum::from($request->input("req-{$req->id}-decision"));
                $notes = $request->input("req-{$req->id}-notes");

                //Por defecto, al aprobar o rechazar se quita el permiso de quien actua sobre de ella, a menos que la devuelva
                $nextOwnerPermission = null;
                $nextStatus = null;
                $action = null;
                switch ($decision) {
                    case RequisitionApprovalDecisionEnum::APPROVED:
                        $nextStatus = RequisitionStatusEnum::AUTHORIZED_BY_DG;
                        $action = "Aprobada por D.G.";
                        break;
                    case RequisitionApprovalDecisionEnum::RETURNED:
                        $nextStatus = RequisitionStatusEnum::RETURNED_BY_DG;
                        $action = "Devuelta por D.G.";

                        $nextOwnerPermission = RequisitionOwnerPermissionEnum::TREASURY->value;
                        $allDecided = false;
                        break;
                    case RequisitionApprovalDecisionEnum::DENIED:
                        $nextStatus = RequisitionStatusEnum::DENIED_BY_DG;
                        $action = "Rechazada por D.G.";
                        break;
                    
                    default:
                    $status = false;
                    $error = "Ha ocurrido un error";
                    return [$status, $error];
                }

                $req->update([
                    'current_owner_permission' => $nextOwnerPermission,
                ]);

                $this->createLog($req, $nextStatus, $action);
                $this->createApproval($requisition_global, $req, $decision, $notes);
            }

            //Solamente si todas estan APROBADAS o RECHAZADAS, se finaliza
            if ($allDecided){
                $nextGlobalStatus = RequisitionGlobalStatus::where('name', RequisitionGlobalStatusEnum::FINALIZED->value)->first();
                $requisition_global->update([
                    'requisition_global_status_id' => $nextGlobalStatus->id,
                ]);

                //DEFINE A LOS USUARIOS DE TESORERIA COMO DESTINATARIOS
                $treasuryRole = Role::where('name', 'Tesorería')->first();
                $receivers = User::where('role_id', $treasuryRole->id)->get()->all();

                $params = [
                    'subject' => 'Requisición global finalizada',
                    'title' => "Requisición global finalizada - {$requisition_global->id}",
                    'message' => 'La requisición global ha concluido su proceso de revisión y autorización.',
                    'url' => route('requisition_globals.show', $requisition_global->id),
                ];
                $this->sendMail($receivers, $params);
            }

        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error];
    }

    // HELPERS
    private function deleteNonExistentRequisitions(array $requisitionIds, RequisitionGlobal $requisition_global){        
        $existingReqs = $requisition_global->requisitions;
        
        $nextOwnerPermission = RequisitionOwnerPermissionEnum::TREASURY;
        foreach ($existingReqs as $key => $req) {
            if (!in_array($req->id, $requisitionIds)){
                $req->update([
                    'requisition_global_id' => null,
                    'current_owner_permission' => $nextOwnerPermission->value,
                ]);

                $this->createLog($req, RequisitionStatusEnum::STAND_BY_TREASURY, "En espera para Global");
            }
        }
    }

    private function createApproval(RequisitionGlobal $requisition_global, Requisition $requisition, RequisitionApprovalDecisionEnum $decisionEnum, ?string $notes){
        RequisitionApproval::create([
            'user_id' => auth()->id(),
            'requisition_id' => $requisition->id,
            'requisition_global_id' => $requisition_global->id,
            'role_id' => auth()->user()->role->id,
            'decision' => $decisionEnum->value,
            'notes' => $notes,
        ]);
    }

    private function createLog(Requisition $requisition, RequisitionStatusEnum $nextStatusEnum, string $action){
        $lastLog = $requisition->lastLog;
        $nextStatus = RequisitionStatus::where('name', $nextStatusEnum->value)->first();

        RequisitionLog::create([
            'requisition_id' => $requisition->id,
            'user_id' => auth()->id(),
            'role_id' => auth()->user()->role->id,
            'action' => $action,
            'from_status_id' => $lastLog->to_status_id,
            'to_status_id' => $nextStatus->id,
        ]);
    }

    private function sendMail($receivers, array $params){
        //Normaliza el arreglo                
        if (!is_array($receivers)){
            $receivers = [$receivers];
        }

        if (config('app.sent_mails')) {
            foreach ($receivers as $receiver) {
                if ($receiver->email && !str_contains($receiver->email, 'DN')) {
                    Mail::to($receiver->email)->queue((new RequisitionGlobalMail($receiver->name, $params))->onQueue("mails"));
                    // Mail::to($receiver->email)->send((new RequisitionGlobalMail($receiver, $params)));
                }
            }
        }
    }
}