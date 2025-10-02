<?php

namespace App\Exports\Commissions;

use App\Models\Commission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithTitle;

class PolizaSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function __construct($processedData, $dates, $outSourcing)
    {
        $this->processedData = $processedData;
        $this->dates = $dates;
        $this->outSourcing = $outSourcing;
    }

    public function collection()
    {
        $data = collect($this->processedData)->map(function ($item) {
            return [
                $item->accounting_account,
                (($item->total_commission + ($item->total_commission * ($this->outSourcing / 100)))) / 1.16,
                '',
                $item->segment,
            ];
        });

        $total = $data->sum(function ($row) {
            return $row[1]; 
        });

        $iva = $data->sum(function ($row) {
            return ($row[1] * 0.16); 
        });

        $data->push([
            '11901001', $iva,
        ]);

        // Agrega la fila de total
        $data->push([
            '20101433','', $total + $iva,
        ]);

        return $data;
    }


    public function headings(): array
    {
        $rows = [];

        $initial_date = Carbon::parse($this->dates["initial_date"])->format('d/m/Y');
        $final_date = Carbon::parse($this->dates["final_date"])->format('d/m/Y');

        if ($initial_date == $final_date) {
            $rows[] = ['POLIZA CONTABLE del '.$initial_date]; // Encabezado de sección (corregido con mayúsculas limpias)

        }else{
            $rows[] = ['POLIZA CONTABLE del'.$initial_date." a ".$final_date]; // Encabezado de sección (corregido con mayúsculas limpias)
        }

        $rows[] = [
            'CUENTA',
            'CARGOS',
            'ABONOS',
            'SEGMENTO'
        ];

        return $rows;
    }

    public function title(): string
    {
        return 'Poliza';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        $sheet->getStyle('B1:B' . $sheet->getHighestRow())
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
            
        $sheet->getStyle('C1:C' . $sheet->getHighestRow())
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);

        $sheet->mergeCells('A1:D1');
        
        return [
            'A1:D2' => [ // Aplica a la sección de COMISIONES
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '3c9fb5'], // azul oscuro
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];

    }
}
