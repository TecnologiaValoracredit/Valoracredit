<?php

namespace App\Http\Controllers;

use App\DataTables\RequisitionRowsDataTable;
use App\Exports\RequisitionRequestExport;
use App\Models\RequisitionMonthRegistry;
use App\Models\RequisitionResponse;
use App\Models\RequisitionStatus;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\PaymentType;
use App\Models\Branch;
use App\Models\User;
use App\Models\Departament;
use App\Models\Supplier;
use App\Models\CurrencyType;
use App\DataTables\RequisitionDataTable;
use App\Models\PermissionModule;
use App\Models\RequisitionRow;
use App\Models\RequisitionRowOptional;
use Illuminate\Support\Facades\Auth; 
use App\Http\Requests\RequisitionRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequisitionMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Webklex\PDFMerger\PDFMerger;
use Illuminate\Filesystem\Filesystem;

class RequisitionController extends Controller
{
    
    public function index(RequisitionDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("requisitions.create");
        return $dataTable->render('requisitions.index', compact("allowAdd"));
    }

    public function create()
    {
        $user = auth()->user();
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");

        return view('requisitions.create', compact('user','departaments', 'payment_types', 'branches', 'suppliers', 'currency_types'));
    }

    public function store(Request $request)
    {
        $status = true;
        $message = null;
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

        // Agrupa en un arreglo todos los archivos de evidencia
        $files = [];
        for ($i=0; $i < count($products); $i++) {
            $evidenceLength = $products[$i]['product_'.$i.'_evidence_length'];
            
            for ($j=0; $j < $evidenceLength; $j++) { 
                $value = $products[$i]['product_'.$i.'_evidence_'.$j];
                array_push($files, $value);
            }
        }

        
        try {
            $user = User::where('id', $request->request_id)->first();        
            $params = array_merge($request->all(), [
                'folio' => $this->generateFolio() ?? null,
                'request_id' => $request->request_id,
                'boss_id' => $user->boss ?? $user->id, // SI EL USUARIO ES SU MISMO JEFE, EL MISMO PUEDE AUTORIZAR
                'current_status_id' => 1,
                'payment_type_id' => $request->payment_type_id,
                'amount' => $request->amount,
                'request_date' => now(),
                'departament_id' => $request->departament_id,
                'branch_id' => $request->branch_id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'is_urgent' => $request->is_urgent ? 1 : 0,
                'notes' => $request->notes,
            ]);
            $requisition = Requisition::create($params);
            
            try {
                $evidencePath = $this->saveEvidenceToPdf($files, $requisition);
                for ($i=0; $i < count($products); $i++) { 
                    RequisitionRow::create([
                        'product' => $products[$i]['product_'.$i.'_product'],
                        'product_description' => $products[$i]['product_'.$i.'_product_description'],
                        'product_quantity' => $products[$i]['product_'.$i.'_product_quantity'],
                        'product_cost' => $products[$i]['product_'.$i.'_product_cost'],
                        'has_iva' => $products[$i]['product_'.$i.'_has_iva'] == 'on' ? 1 : 0,
                        'total_cost' => $products[$i]['product_'.$i.'_total_cost'],
                        'reason' => $products[$i]['product_'.$i.'_reason'],
                        'evidence' => $evidencePath,
                        'link' => $products[$i]['product_'.$i.'_link'],
                        'currency_type_id' => $products[$i]['product_'.$i.'_currency_type_id'],
                        'requisition_id' => $requisition->id,
                        'supplier_id' => $products[$i]['product_'.$i.'_supplier_id'],
                    ]);
                }
                $message = "Requisición creada correctamente";
            } catch (QueryException $e) {
                $status = false;
                $message = $this->getErrorMessage($e, 'requisition_rows');
            }

        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'requisitions');
        }

        return $this->getResponse($status, $message, $requisition);
    }
    
    
    
    public function edit(Requisition $requisition)
    {
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        $suppliers = Supplier::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");

        $user = auth()->user();
        $boss = $user->boss ?? 1;

        $requisition_rows = $requisition->requisitionRows()->get();

        return view('requisitions.edit', compact('requisition', 'payment_types', 'branches', 'suppliers', 'currency_types', 'departaments', 'user', 'boss', 'requisition', 'requisition_rows'));
    }
    
    public function update(Request $request, Requisition $requisition)
    {
        $status = true;
        
        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
            'update_at' => now(),
            'update_by' => auth()->user()
		]);
        try {
			$requisition->update($params);
			$message = "Requisición modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'requisition');
		}

         return $this->getResponse($status, $message, $requisition);
    }    

    public function destroy(Requisition $requisition)
    {
        $status = true;
        try{
            if($requisition->requisition_status_id == 1){
                $requisitionRows = $requisition->requisitionRows;

                foreach($requisitionRows as $key => $requisitionRow)
                {
                    $requisitionRow->delete();
                }
                    $requisition->delete();
                    $message = "Requisición eliminada correctamente";

            }
        }catch(\Illuminate\Database\QueryException $e){
            $status = false;
            $message = $this->getErrorMessage($e, 'requisition');
        }


          return $this->getResponse($status, $message);
    }

    public function show(Requisition $requisition)
    {
        $payment_types = PaymentType::where("is_active", 1)->pluck("name", "id");
        $departaments = Departament::where("is_active", 1)->pluck("name", "id");
        $branches = Branch::where("is_active", 1)->pluck("name", "id");
        

        $requisitionRowsDataTable = new RequisitionRowsDataTable($requisition, null, true);
        $params = ['requisition' => $requisition, 'requisitionRow' => null, 'is_show' => true];
        $requisitionRowsDT = $this->getViewDataTable($requisitionRowsDataTable, 'requisition_rows', [], 'requisition_rows.getRequisitionRowsDataTable', $params);

        // Retornamos la vista 'requisitions.show' pasando las variables necesarias
        return view('requisitions.show', compact('requisition', 'payment_types', 'departaments', 'branches', 'requisitionRowsDT'));
    }
    
    
    public function exportReport(Requisition $requisition) {
        $pdf = Pdf::loadView('requisitions.pdf.requisitionRequest', [
            'requisition' => $requisition
        ])->setPaper('letter', 'portrait');

        return $pdf->download('requisition'.$requisition->id.'.pdf');
    }
    
    public function changeStatus(Requisition $requisition,  $requisition_status){
        $message = "";
        $requisition_status = RequisitionStatus::findOrFail($requisition_status);
        $user = auth()->user();
        try {
            $requistion_response = RequisitionResponse::create([
                "requisition_id" => $requisition->id,
                "requisition_status_id" => $requisition_status->id,
                "reason" => "example",
                "user_id" => $user->id,
                "created_at" => now(),
                "updated_at" => now(),
                "created_by" => $user->id,
                "updated_by" => $user->id,

            ]);
			$requisition->requisition_status_id = $requisition_status->id;
            $requisition->save();
			$message = "Requisición modificada correctamente";
		} catch (QueryException $e) {
			$status = false;
			$message = $this->getErrorMessage($e, 'requisition');
		}
    }

    //HELPERS

    private function sendMail(User $receiver, string $message, Requisition $requisition){
        Mail::send(new RequisitionMail($receiver, $requisition));
    }

    private function saveEvidenceToPdf($files, $requisition){
        $hasPdf = false;
        $pdfFiles = [];
        
        // Detecta si hay PDFs entre las evidencias dadas
        $count = count($files);
        for ($i = 0; $i < $count; $i++) {
            $extension = substr($files[$i]->getClientOriginalName(), -3);
            if ($extension == 'pdf'){
                $hasPdf = true;
                array_push($pdfFiles, $files[$i]);
                unset($files[$i]);
            }
        }

        $encodedImages = [];
        foreach ($files as $file) {
            $encodedImages[] = [
                'mime' => $file->getMimeType(),
                'data' => base64_encode(file_get_contents($file->getRealPath())),
            ];
        }

        $pdf = Pdf::loadView('requisitions.pdf.evidence', [
            'encodedImages' => $encodedImages,
            'requisition' => $requisition,
        ]);

        $fileName = 'Evidencia_Requisición_'.$requisition->id.'_.pdf';
        $path = "requisitions/evidences/{$requisition->id}/" . $fileName;

        Storage::disk('public')->put($path, $pdf->output());
        
        if ($hasPdf){
            $merger = new PDFMerger(new Filesystem());

            // Añade al merger el pdf anterior junto con todas sus paginas
            $merger->addPDF(storage_path('app/public/' . $path), 'all');

            $pathsToErase = [];
            for ($i=0; $i < count($pdfFiles); $i++) { 
                $pdfPath = "requisitions/evidences/{$requisition->id}/PDF_Evidence_{$i}.pdf";
                array_push($pathsToErase, $pdfPath);

                Storage::disk('public')->put($pdfPath, file_get_contents($pdfFiles[$i]->getRealPath()));
    
                // Añade la evidencia de la evidencia en PDF
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

    private function generateFolio(){
        $currentMonth = strtoupper(date('M'));

        $lastRegistry = RequisitionMonthRegistry::latest()->first();
        $lastRegistryMonth = strtoupper($lastRegistry->created_at->format('M'));

        $newIndex = '';
        if ($lastRegistryMonth == $currentMonth){
            $newIndex = str_pad(((int)$lastRegistry->last_index + 1), 2, '0', STR_PAD_LEFT);
        }
        else{
            $newIndex = '00';
        }

        RequisitionMonthRegistry::create([
            'last_index' => $newIndex
        ]);

        $folio = "REQ-{$currentMonth}-{$newIndex}";

        return $folio;
    }
}