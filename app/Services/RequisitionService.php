<?php

namespace App\Services;

use App\Http\Requests\RequisitionRequest;
use App\Models\Requisition;
use App\Models\RequisitionRow;
use App\Models\RequisitionStatus;
use App\Models\RequisitionLog;
use App\Models\RequisitionEntry;
use App\Models\FixedExpense;
use App\Models\ExpenseDuration;
use Carbon\Carbon;
use App\Models\RequisitionApproval;
use App\Models\RequisitionPayment;
use App\Models\RequisitionRowEvidence;
use App\Models\User;
use App\Models\Role;
use App\Enums\RequisitionOwnerPermissionEnum;
use App\Enums\RequisitionStatusEnum;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Webklex\PDFMerger\PDFMerger;
use Illuminate\Filesystem\Filesystem;
use Barryvdh\DomPDF\Facade\Pdf;
use function PHPUnit\Framework\isNull;

use Illuminate\Support\Facades\Mail;
use App\Mail\RequisitionMail;


class RequisitionService
{
    public function __construct()
    {

    }

    public function createInitialLog(Requisition $requisition){
        $createdStatus = RequisitionStatus::where('name', 'Creada')->first();
        
        RequisitionLog::create([
            'requisition_id' => $requisition->id,
            'user_id' => auth()->id(),
            'role_id' => auth()->user()->role->id,
            'action' => "Requisición creada",
            'from_status_id' => null,
            'to_status_id' => $createdStatus->id,
        ]);
    }

    public function store(Request $request) {
        $status = true;
        $error = null;
        $requisition = null;

        // Limpia los datos de los productos de la requisición y agrupa en un arreglo
        $products = [];
        $counter = $request->products_length;
        for ($i = 0; $i < $counter; $i++) {
            foreach ($request->all() as $key => $value) {
                if (str_contains($key, 'product_'. $i)){
                    $products[$i][$key] = $value;
                }
            }
        }
        
        try {
            $user = User::where('id', $request->request_id)->first();

            //Crea datos de la requisicion
            $params = array_merge($request->all(), [
                'folio' => $this->generateFolio() ?? null,
                'request_id' => $request->request_id,
                'boss_id' => $user->boss->id ?? $user->id, // SI EL USUARIO ES SU MISMO JEFE, EL MISMO PUEDE AUTORIZAR
                'payment_type_id' => $request->payment_type_id,
                'amount' => $request->amount,
                'request_date' => now(),
                'departament_id' => $request->departament_id,
                'branch_id' => $request->branch_id,
                'supplier_id' => $request->supplier_id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_urgent' => $request->is_urgent ? 1 : 0,
                'total' => $request->total,
                'notes' => $request->notes,
                'current_owner_permission' => null,
            ]);
            $requisition = Requisition::create($params);
            
            try {
                /** @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
                $fileSystem = Storage::disk('public');

                //Por cada producto de la requisicion, crea sus datos y su instancia
                for ($i=0; $i < count($products); $i++) {
                    if (isset($products[$i]['product_'.$i.'_expense_duration_id']) && isset($products[$i]['product_'.$i.'_starting_date'])){
                        $expense_duration_id = $products[$i]['product_'.$i.'_expense_duration_id'];
                        $starting_date = $products[$i]['product_'.$i.'_starting_date'];
                    }
                    
                    $rowParams = [
                        'product' => $products[$i]['product_'.$i.'_product'],
                        'product_description' => $products[$i]['product_'.$i.'_product_description'],
                        'product_quantity' => $products[$i]['product_'.$i.'_product_quantity'],
                        'product_cost' => $products[$i]['product_'.$i.'_product_cost'],
                        'has_iva' => $products[$i]['product_'.$i.'_has_iva'] == 'on' ? 1 : 0,
                        'total_cost' => $products[$i]['product_'.$i.'_total_cost'],
                        'reason' => $products[$i]['product_'.$i.'_reason'] ?? null,
                        'link' => $products[$i]['product_'.$i.'_link'],
                        'currency_type_id' => $products[$i]['product_'.$i.'_currency_type_id'],
                        'requisition_id' => $requisition->id,
                        'iva_percentage' => $products[$i]['product_'.$i.'_iva_percentage'],
                    ];

                    //SI SI PUSIERON EXPENSE DURATION Y STARTING DATE
                    if (isset($products[$i]['product_'.$i.'_expense_duration_id']) && isset($products[$i]['product_'.$i.'_starting_date'])){
                        $rowParams = array_merge($rowParams, [
                            'expense_duration_id' => $expense_duration_id,
                            'starting_date' => $starting_date,
                            'ending_date' => $this->generateEndingDate($expense_duration_id, $starting_date),
                        ]);

                    }
                    $requisitionRow = RequisitionRow::create($rowParams);

                    //Por cada evidencia de el producto, se crean datos de la evidencia y se almacenan
                    $evidenceLength = $products[$i]['product_'.$i.'_evidence_length'];
                    for ($j=0; $j < $evidenceLength; $j++) { 
                        $file = $request->file('product_'.$i.'_evidence_'.$j);
                        $fileExtension = $file->getClientOriginalExtension();
                        $fileName = "Product_{$requisitionRow->id}_evidence_{$j}.{$fileExtension}";

                        $path = $fileSystem->putFileAs('requisition_rows_evidences', $file, $fileName);

                        $rowEvidenceParams = [
                            'requisition_row_id' => $requisitionRow->id,
                            'path' => $path,
                            'is_active' => true,
                        ];

                        RequisitionRowEvidence::create($rowEvidenceParams);
                    }
                }

                $this->createInitialLog($requisition);

                if ($request->is_fixed){
                    $this->createFixedExpense( [
                        'fixed_expense_name' => $request->fixed_expense_name,
                        'fixed_expense_description' => $request->fixed_expense_description,
                        'requisition_id' => $requisition->id,
                    ]);
                }
            } catch (QueryException $e) {
                $status = false;
                $error = $e;
            }

        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error, $requisition];
    }

    public function update(Request $request, Requisition $requisition){
        $status = true;
        $error = null;

        // Limpia los datos de los productos de la requisición y agrupa en un arreglo
        $products = [];
        $counter = $request->products_length;
        for ($i = 0; $i < $counter; $i++) {
            foreach ($request->all() as $key => $value) {
                if (str_contains($key, 'product_'. $i)){
                    $products[$i][$key] = $value;
                }
            }
        }

        try {
            // Actualiza los datos de la requisición
            $params = array_merge($request->all(), [
                'payment_type_id' => $request->payment_type_id,
                'supplier_id' => $request->supplier_id,
                'amount' => $request->amount,
                'updated_by' => auth()->id(),
                'is_urgent' => $request->is_urgent ? 1 : 0,
                'notes' => $request->notes,
            ]);

            $requisition->update($params);
            try {
                $this->deleteNonExistentProducts($requisition, $products);

                /** @var \Illuminate\Filesystem\FilesystemAdapter $fileSystem */
                $fileSystem = Storage::disk('public');

                //Por cada producto de la requisicion, crea sus datos y su instancia
                for ($i=0; $i < count($products); $i++) {
                    if (isset($products[$i]['product_'.$i.'_expense_duration_id']) && isset($products[$i]['product_'.$i.'_starting_date'])){
                        $expense_duration_id = $products[$i]['product_'.$i.'_expense_duration_id'];
                        $starting_date = $products[$i]['product_'.$i.'_starting_date'];
                    }

                    $rowParams = [
                        'product' => $products[$i]['product_'.$i.'_product'],
                        'product_description' => $products[$i]['product_'.$i.'_product_description'],
                        'product_quantity' => $products[$i]['product_'.$i.'_product_quantity'],
                        'product_cost' => $products[$i]['product_'.$i.'_product_cost'],
                        'has_iva' => $products[$i]['product_'.$i.'_has_iva'] == 'on' ? 1 : 0,
                        'total_cost' => $products[$i]['product_'.$i.'_total_cost'],
                        'reason' => $products[$i]['product_'.$i.'_reason'] ?? null,
                        'link' => $products[$i]['product_'.$i.'_link'],
                        'currency_type_id' => $products[$i]['product_'.$i.'_currency_type_id'],
                        'requisition_id' => $requisition->id,
                        'iva_percentage' => $products[$i]['product_'.$i.'_iva_percentage'],
                    ];

                    //SI SI PUSIERON EXPENSE DURATION Y STARTING DATE
                    if (isset($products[$i]['product_'.$i.'_expense_duration_id']) && isset($products[$i]['product_'.$i.'_starting_date'])){
                        $rowParams = array_merge($rowParams, [
                            'expense_duration_id' => $expense_duration_id,
                            'starting_date' => $starting_date,
                            'ending_date' => $this->generateEndingDate($expense_duration_id, $starting_date),
                        ]);
                    }

                    $requisitionRow = null;
                    // Si el producto ya existía, actualiza su información
                    if (isset($products[$i]["product_{$i}_row_id"])){
                        $requisitionRow = RequisitionRow::where('id', $products[$i]["product_{$i}_row_id"])->first();
                        $requisitionRow->update($rowParams);
                    }
                    else{
                        $requisitionRow = RequisitionRow::create($rowParams);
                    }
                    
                    if (isset($products[$i]['product_'.$i.'_evidence_length'])){
                        //Por cada evidencia de el producto, se crean datos de la evidencia y se almacenana
                        $evidenceLength = $products[$i]['product_'.$i.'_evidence_length'];
                        for ($j=0; $j < $evidenceLength; $j++) { 
                            $file = $request->file('product_'.$i.'_evidence_'.$j);
                            $fileExtension = $file->getClientOriginalExtension();
                            $fileName = "Product_{$requisitionRow->id}_evidence_{$j}.{$fileExtension}";
    
                            $path = $fileSystem->putFileAs('requisition_rows_evidences', $file, $fileName);
    
                            $rowEvidenceParams = [
                                'requisition_row_id' => $requisitionRow->id,
                                'path' => $path,
                                'is_active' => true,
                            ];
    
                            RequisitionRowEvidence::create($rowEvidenceParams);
                        }
                    }

                }
            } catch (QueryException $e) {
                $status = false;
                $error = $e;
            }
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error, $requisition];
    }

    public function send(Request $request, Requisition $requisition){
        $status = true;
        $error = null;

        $requisitionStatusEnum = null;
        $nextOwnerPermission = null;
        $action = null;
        switch ($requisition->current_owner_permission) {
            // SI EL JEFE ENVIA
            case RequisitionOwnerPermissionEnum::BOSS->value:
                $requisitionStatusEnum = RequisitionStatusEnum::SENT_TO_TREASURY;
                $nextOwnerPermission = RequisitionOwnerPermissionEnum::TREASURY;
                $action = "Enviada a Tesoreria";

                //DEFINE A LOS USUARIOS DE TESORERIA COMO DESTINATARIOS
                $treasuryRole = Role::where('name', 'Tesorería')->first();
                $receivers = User::where('role_id', $treasuryRole->id)->get()->all();

                $params = [
                    'subject' => 'Requisición pendiente de aprobación',
                    'title' => "Requisición enviada para aprobación - {$requisition->folio}",
                    'message' => 'Se ha enviado una requisición para su revisión y aprobación de Tesorería.',
                    'url' => route('requisitions.changeStatus', $requisition->id),
                ];
                $this->sendMail($receivers, $params);

                break;
            //SI TESORERIA ENVIA
            case RequisitionOwnerPermissionEnum::TREASURY->value:
                $requisitionStatusEnum = RequisitionStatusEnum::SENT_TO_ACCOUNTING;
                $nextOwnerPermission = RequisitionOwnerPermissionEnum::ACCOUNTING;
                $action = "Enviada a Contabilidad";
                break;
                
            //SI EL APLICANTE LA ESTA MANDANDO
            default:
                //SI EL USUARIO ES SU PROPIO JEFE, MANDA DIRECTAMENTE A TESORERIA
                if ($requisition->boss_id == auth()->id()){
                    $requisitionStatusEnum = RequisitionStatusEnum::SENT_TO_TREASURY;
                    $nextOwnerPermission = RequisitionOwnerPermissionEnum::TREASURY;
                    $action = "Enviada a Tesoreria";

                    $treasuryRole = Role::where('name', 'Tesorería')->first();
                    $receivers = User::where('role_id', $treasuryRole->id)->get()->all();

                    $params = [
                        'subject' => 'Requisición pendiente de aprobación',
                        'title' => "Requisición enviada para aprobación - {$requisition->folio}",
                        'message' => 'Se ha enviado una requisición para su revisión y aprobación de Tesorería.',
                        'url' => route('requisitions.changeStatus', $requisition->id),
                    ];
                    $this->sendMail($receivers, $params);
                    break;
                }

                $requisitionStatusEnum = RequisitionStatusEnum::SENT_TO_BOSS;
                $nextOwnerPermission = RequisitionOwnerPermissionEnum::BOSS;
                $action = "Enviada a Jefe Inmediato";

                //DEFINE AL JEFE COMO DESTINATARIO
                $receivers = $requisition->boss;
                $params = [
                    'subject' => 'Requisición pendiente de aprobación',
                    'title' => "Requisición enviada para aprobación - {$requisition->folio}",
                    'message' => 'Se ha enviado una requisición para su revisión y aprobación del Jefe Inmediato.',
                    'url' => route('requisitions.changeStatus', $requisition->id),
                ];
                $this->sendMail($receivers, $params);
                break;
        }

        $lastLog = $requisition->lastLog;
        $updatedStatus = RequisitionStatus::where('name', $requisitionStatusEnum->value)->first();

        try {
            RequisitionLog::create([
            'requisition_id' => $requisition->id,
            'user_id' => auth()->id(),
            'role_id' => auth()->user()->role->id,
            'action' => $action ?? "NULL",
            'from_status_id' => $lastLog->to_status_id,
            'to_status_id' => $updatedStatus->id,
            'notes' => $request->notes,
            ]);
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        $requisition->update([
           'current_owner_permission' => $nextOwnerPermission->value,
        ]);

        return [$status, $error];
    }

    public function destroy(Requisition $requisition){
        $status = true;
        $error = null;

        $rows = $requisition->requisitionRows;
        foreach($rows as $row){
            $row->deleteEvidences();
            $row->delete();
        }

        try {
            $requisition->update([
                'is_active' => false, 
            ]);
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error];
    }

    public function return(Request $request, Requisition $requisition){
        $status = true;
        $error = null;

        $requisitionStatusEnum = null;
        $nextOwnerPermission = null;
        switch ($requisition->current_owner_permission) {
            case RequisitionOwnerPermissionEnum::BOSS->value:
                $requisitionStatusEnum = RequisitionStatusEnum::RETURNED_BY_BOSS;
                $nextOwnerPermission = null;
                break;
            case RequisitionOwnerPermissionEnum::TREASURY->value:
                $requisitionStatusEnum = RequisitionStatusEnum::RETURNED_BY_TREASURY;
                $nextOwnerPermission = RequisitionOwnerPermissionEnum::BOSS;
                break;
        }
        
        $lastLog = $requisition->lastLog;
        $updatedStatus = RequisitionStatus::where('name', $requisitionStatusEnum->value)->first();

        try {
            RequisitionLog::create([
            'requisition_id' => $requisition->id,
            'user_id' => auth()->id(),
            'role_id' => auth()->user()->role->id,
            'action' => "Requisición devuelta",
            'from_status_id' => $lastLog->to_status_id,
            'to_status_id' => $updatedStatus->id,
            'notes' => $request->notes,
            ]);
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        $requisition->update([
           'current_owner_permission' => $nextOwnerPermission->value ?? null,
        ]);

        return [$status, $error];
    }

    public function cancel(Request $request, Requisition $requisition){
        $status = true;
        $error = null;

        $requisitionStatusEnum = RequisitionStatusEnum::CANCELLED;
        
        $lastLog = $requisition->lastLog;
        $updatedStatus = RequisitionStatus::where('name', $requisitionStatusEnum->value)->first();

        try {
            RequisitionLog::create([
            'requisition_id' => $requisition->id,
            'user_id' => auth()->id(),
            'role_id' => auth()->user()->role->id,
            'action' => "Requisición cancelada por Jefe Inmediato",
            'from_status_id' => $lastLog->to_status_id,
            'to_status_id' => $updatedStatus->id,
            'notes' => $request->notes,
            ]);
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        $requisition->update([
           'current_owner_permission' => null,
        ]);

        return [$status, $error]; 
    }

    public function deny(Request $request, Requisition $requisition){
        $status = true;
        $error = null;

        $requisitionStatusEnum = null;
        $action = null;
        switch ($requisition->current_owner_permission) {
            case RequisitionOwnerPermissionEnum::BOSS->value:
                $requisitionStatusEnum = RequisitionStatusEnum::DENIED_BY_BOSS;
                $action = "Requisición denegada por Jefe Inmediato";
                break;
            case RequisitionOwnerPermissionEnum::ACCOUNTING->value:
                $requisitionStatusEnum = RequisitionStatusEnum::DENIED_BY_ACCOUNTING;
                $action = "Requisición denegada por Contabilidad";
                break;
            case RequisitionOwnerPermissionEnum::DG->value:
                $requisitionStatusEnum = RequisitionStatusEnum::DENIED_BY_DG;
                $action = "Requisición denegada por Dirección General";
                break;
        }

        $lastLog = $requisition->lastLog;
        $updatedStatus = RequisitionStatus::where('name', $requisitionStatusEnum->value)->first();

        try {
            RequisitionLog::create([
            'requisition_id' => $requisition->id,
            'user_id' => auth()->id(),
            'role_id' => auth()->user()->role->id,
            'action' => $action,
            'from_status_id' => $lastLog->to_status_id,
            'to_status_id' => $updatedStatus->id,
            'notes' => $request->notes,
            ]);
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        $requisition->update([
           'current_owner_permission' => null,
        ]);

        return [$status, $error];
    }

    public function approve(Request $request, Requisition $requisition){
        $status = true;
        $error = null;

        $requisitionStatusEnum = null;
        $nextOwnerPermission = null;
        switch ($requisition->current_owner_permission) {
            case RequisitionOwnerPermissionEnum::BOSS->value:
                $requisitionStatusEnum = RequisitionStatusEnum::SENT_TO_TREASURY;
                $nextOwnerPermission = RequisitionOwnerPermissionEnum::TREASURY;
                break;
        }
        
        $lastLog = $requisition->lastLog;
        $updatedStatus = RequisitionStatus::where('name', $requisitionStatusEnum->value)->first();

        try {
            RequisitionLog::create([
            'requisition_id' => $requisition->id,
            'user_id' => auth()->id(),
            'role_id' => auth()->user()->role->id,
            'action' => "Requisición devuelta",
            'from_status_id' => $lastLog->to_status_id,
            'to_status_id' => $updatedStatus->id,
            'notes' => $request->notes,
            ]);
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        $requisition->update([
           'current_owner_permission' => $nextOwnerPermission->value ?? null,
        ]);

        return [$status, $error];        
    }

    public function chargePolicy(RequisitionRequest $request, Requisition $requisition){
        $status = true;
        $error = null;

        $requisitionStatusEnum = RequisitionStatusEnum::STAND_BY_TREASURY;
        $action = "Póliza cargada";
        
        $nextOwnerPermission = RequisitionOwnerPermissionEnum::TREASURY;

        $lastLog = $requisition->lastLog;
        $updatedStatus = RequisitionStatus::where('name', $requisitionStatusEnum->value)->first();

        $files = $request->evidence;
        $path = $this->saveEvidenceToPdf($files, $requisition, "policies", "policy");

        try {
            RequisitionLog::create([
            'requisition_id' => $requisition->id,
            'user_id' => auth()->id(),
            'role_id' => auth()->user()->role->id,
            'action' => $action,
            'from_status_id' => $lastLog->to_status_id,
            'to_status_id' => $updatedStatus->id,
            'notes' => $request->notes,
            ]);

            RequisitionEntry::create([
            'requisition_id' => $requisition->id,
            'poliza_number' => 'NUMERO_DE_POLIZA',
            'path' => $path,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        $requisition->update([
           'current_owner_permission' => $nextOwnerPermission->value,
        ]);

        return [$status, $error];
    }

    public function uploadPayment(Request $request, Requisition $requisition){
        $status = true;
        $error = null;

        $files = $request->file('payment_voucher', []);
        $path = $this->saveEvidenceToPdf($files, $requisition, "payments", "payment");
        try {
            RequisitionPayment::create([
                'requisition_id' => $requisition->id,
                'path' => $path ?? null,
                'created_by' => auth()->id(),
            ]);

            $lastLog = $requisition->lastLog;
            $nextStatus = RequisitionStatus::where('name', RequisitionStatusEnum::PAID->value)->first();

            RequisitionLog::create([
                'requisition_id' => $requisition->id,
                'user_id' => auth()->id(),
                'role_id' => auth()->user()->role->id,
                'action' => "Requisición pagada",
                'from_status_id' => $lastLog->to_status_id,
                'to_status_id' => $nextStatus->id,
            ]);

            //DEFINE COMO DESTINATARIO AL APLICANTE DE LA REQUISICION
            $receivers = $requisition->user;  
            $params = [
                'subject' => 'Comprobante de pago añadido',
                'title' => "Comprobante de pago registrado - {$requisition->folio}",
                'message' => "Se ha registrado un comprobante de pago en la requisición.",
                'url' => route('requisitions.show', $requisition->id),
            ];
            $this->sendMail($receivers, $params);
            
        } catch (QueryException $e) {
            $status = false;
            $error = $e;
        }

        return [$status, $error];
    }

    // HELPERS

    private function generateEndingDate(int $expense_duration_id, string $starting_date){
        $duration = ExpenseDuration::where('id', $expense_duration_id)->first();
        $date = Carbon::parse($starting_date);

        return $date->addDays($duration->days)->toDateString();
    }

    private function generateFolio(){
        $currentMonth = date('n');
        $currentYear = date('Y');

        $currentMonthRequisitions = Requisition::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->get();
        $reqCount = count($currentMonthRequisitions);

        $folioNumber = '01';
        
        if ($reqCount > 0){
            $folioNumber = str_pad(($reqCount + 1), 2, '0', STR_PAD_LEFT);
        }
            
        $folioMonth = strtoupper(date('M'));

        $folio = "REQ-{$folioMonth}-{$folioNumber}";

        return $folio;
    }

    private function sendMail($receivers, array $params){
        //Normaliza el arreglo                
        if (!is_array($receivers)){
            $receivers = [$receivers];
        }

        if (config('app.sent_mails')) {
            foreach ($receivers as $receiver) {
                if ($receiver->email && !str_contains($receiver->email, 'DN')) {
                    Mail::to($receiver->email)->queue((new RequisitionMail($receiver->name, $params))->onQueue("mails"));
                }
            }
        }
    }

    private function deleteNonExistentProducts(Requisition $requisition, $products){
        $existingRows = $requisition->requisitionRows;
        $rowsToDelete = [];

        foreach ($existingRows as $row) {
            $exists = false;

            for ($i = 0; $i < count($products); $i++) {
                if (isset($products[$i]["product_{$i}_row_id"])){
                    if ($products[$i]["product_{$i}_row_id"] == $row->id){
                        $exists = true;
                        break;
                    }
                }
            }

            if ($exists == false){
                array_push($rowsToDelete, $row);
            }
        }

        if (count($rowsToDelete) > 0){
            foreach ($rowsToDelete as $row) {
                $row->deleteEvidences();
                $row->delete();
            }
        }
    }

    private function saveEvidenceToPdf($files, $requisition, string $directory, string $template){

        // Normaliza a array si viene un solo archivo
        if (!is_array($files)) {
            $files = [$files];
        }

        $hasPdf = false;
        $pdfFiles = [];
        
        // Detecta si hay PDFs entre las evidencias dadas
        $count = count($files);
        for ($i = 0; $i < $count; $i++) {

            if (!$files[$i]) continue;

            $extension = strtolower($files[$i]->getClientOriginalExtension());

            if ($extension === 'pdf'){
                $hasPdf = true;
                $pdfFiles[] = $files[$i];
                unset($files[$i]);
            }
        }

        $encodedImages = [];
        foreach ($files as $file) {

            if (!$file) continue;

            $encodedImages[] = [
                'mime' => $file->getMimeType(),
                'data' => base64_encode(file_get_contents($file->getRealPath())),
            ];
        }

        $pdf = Pdf::loadView("requisitions.pdf.{$template}", [
            'encodedImages' => $encodedImages,
            'requisition' => $requisition,
        ]);

        $fileName = 'Evidencia_Requisición_' .$requisition->id.'_.pdf';
        $path = "requisitions/{$directory}/{$requisition->id}/" . $fileName;

        Storage::disk('public')->put($path, $pdf->output());
        
        if ($hasPdf){

            $merger = new PDFMerger(new Filesystem());

            // Añade el PDF generado
            $merger->addPDF(storage_path('app/public/' . $path), 'all');

            $pathsToErase = [];

            foreach ($pdfFiles as $i => $pdfFile) {

                $pdfPath = "requisitions/{$directory}/{$requisition->id}/PDF_Evidence_{$i}.pdf";

                $pathsToErase[] = $pdfPath;

                Storage::disk('public')->put($pdfPath, file_get_contents($pdfFile->getRealPath()));

                $merger->addPDF(storage_path('app/public/' . $pdfPath), 'all');
            }

            $merger->merge();
            $merger->save(storage_path('app/public/' . $path));

            foreach ($pathsToErase as $key) {
                Storage::disk('public')->delete($key);
            }
        }

        return $path;
    }

    private function createFixedExpense(array $params){
        FixedExpense::create([
            'name' => $params['fixed_expense_name'],
            'description' => $params['fixed_expense_description'],
            'requisition_id' => $params['requisition_id'],
        ]);
    }
}