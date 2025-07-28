<?php

namespace App\Exports\Commissions;

use App\Models\Commission;
use App\Models\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithTitle;

class CommissionSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    public function __construct($processedData, $dates)
    {
        $this->processedData = $processedData;
        $this->dates = $dates;
    }

    public function collection()
    {
       
        $data = collect($this->processedData)->map(function ($item) {
            return [
                $item->bank_name,
                $item->account_number,
                User::where("id",$item->user_id)->first()->user_type,
                $item->user_name,
                $item->total_commission,
                Carbon::parse($item->sale_day)->format('d/m/Y'),
            ];
        });

        $totalComisiones = $data->sum(function ($row) {
            return $row[4]; // índice de 'total_commission'
        });

        // Agrega la fila de total
        $data->push([
            '', '', '', 'TOTAL', $totalComisiones, ''
        ]);

        return $data;

    }


    public function headings(): array
    {
        $rows = [];

        $initial_date = Carbon::parse($this->dates["initial_date"])->format('d/m/Y');
        $final_date = Carbon::parse($this->dates["final_date"])->format('d/m/Y');

        if ($initial_date == $final_date) {
            $rows[] = ['COMISIONES GENERADAS', null, null, null, $initial_date]; // Encabezado de sección (corregido con mayúsculas limpias)

        }else{
            $rows[] = ['COMISIONES GENERADAS', null, null, null, $initial_date." a ".$final_date]; // Encabezado de sección (corregido con mayúsculas limpias)
        }

        $rows[] = [
            'BANCO',
            'CUENTA',
            'TIPO',
            'BENEFICIARIO',
            'IMPORTE',
            'FECHA',
        ];

        return $rows;
    }

    public function title(): string
    {
        return 'Comisiones';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getStyle('E1:E' . $sheet->getHighestRow())
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD);
        $sheet->mergeCells('A1:E1');
        
        return [
            'A1:F1' => [ // Aplica a la sección de COMISIONES
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'a1051a'], // rojo oscuro
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'F1' => [ // Aplica a una celda específica como encabezado de otra sección
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'a1051a'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'A2:F2' => [ // Encabezados de tabla
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'd91832'],
                ],
            ],
        ];

    }
}
