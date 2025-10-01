<?php

namespace App\Exports;

use App\Models\Requisition;
use App\Models\RequisitionRow;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Files\LocalTemporaryFile;
use Maatwebsite\Excel\Excel;

class RequisitionRequestExport implements WithEvents
{
     private $alphabetRange;
    public $requisition;
    public $table;
    
    public function __construct(Requisition $requisition){
        $this->requisition = $requisition;
        $this->table = $this->buildTable($requisition);
    }

    public function buildTable(Requisition $requisition){
        $table = [["ÁREA", "PROVEEDOR", "CANTIDAD", "DESCRIPCIÓN", "TOTAL"]];

        foreach($requisition->requisitionRows as $key => $row){
            array_push($table, 
                [
                    "ÁREA" => $requisition->departament->name,
                    "PROVEEDOR" => $row->supplier->name,
                    "CANTIDAD" => $row->product_quantity,
                    "DESCRIPCIÓN" => $row->product_description,
                    "TOTAL" => $row->total_cost
                ]
                );
        }
        return $table;
    }

    public function registerEvents(): array
    {
        return[
            BeforeWriting::class => function(BeforeWriting $event){
                $template = new LocalTemporaryFile(storage_path('app\templates\RequisitionTemplate.xlsx'));
                $event->writer->reopen($template, Excel::XLSX);
                $sheet0 = $event->getWriter()->getSheetByIndex(0);

                //Fecha de la solicitud
                $sheet0->setCellValue("G3", date("d/m/Y",strtotime($this->requisition->request_date)));

                //Nombre del que solicita la requisición
                $sheet0->setCellValue("B4", $this->requisition->user->name);

                //Nombre del departamento
                $sheet0->setCellValue("B5", $this->requisition->departament->name);

                //Forma de pago
                $sheet0->setCellValue("B6", $this->requisition->paymentType->name);

                //Monto
                $sheet0->setCellValue("B7", $this->requisition->amount);
                


            }
        ];
    }


}
