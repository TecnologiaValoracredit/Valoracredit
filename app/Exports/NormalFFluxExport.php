<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\FMovementType;
use App\Models\FClasification;
use App\Models\FCobClasification;
use App\Models\FStatus;
use App\Models\FCarteraStatus;

class NormalFFluxExport implements FromCollection, WithHeadings, WithStyles
{

    public function __construct($processedData)
    {
        $this->processedData = $processedData;

    }

    public function collection()
    {
        return collect($this->processedData);
    }


    public function headings(): array
    {
        return [
            'Fecha de Acreditación',
            'Beneficiario',
            'Concepto',
            'Tipo de Movimiento',
            'Monto',
            'Clasificación Admon.',
            'Clasificación Cartera',
            'Notas Admin.',
            'Notas cartera',
            'Estatus contabilidad',
            'Estatus cartera'
        ];
    }


    public function styles(Worksheet $sheet)
    {
        // Definir colores
        $greenColor = '98FB98'; // Verde claro (más suave y menos brillante)
    
        // Obtener la última fila y columna
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
    
        // Congelar el panel superior
        $sheet->freezePane('B2');
    
        // Estilo para los encabezados (se mantienen con color de fondo azul oscuro y texto blanco)
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true, // Negritas
                'size' => 12,   // Tamaño de letra más grande
                'color' => ['argb' => 'FFFFFF'], // Color de letra blanco
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'], // Fondo azul oscuro para encabezados
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Centrado horizontal
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Centrado vertical
            ],
        ]);
    
        // Ajustar el tamaño de las columnas automáticamente
        for ($colIndex = 1; $colIndex <= $highestColumnIndex; $colIndex++) {
            $col = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($col)->setAutoSize(true); // Ajustar el tamaño de la columna
        }
    
        // Agregar filtros a las columnas (se aplica a la primera fila, que son los encabezados)
        $sheet->setAutoFilter('A1:' . $highestColumn . '1');
    
        // Formatear la columna de fecha (por ejemplo, si la fecha está en la columna A)
        $dateColumn = 'A'; // Cambia esto si la columna de fecha está en otra columna
        $sheet->getStyle($dateColumn . '2:' . $dateColumn . $highestRow)
            ->getNumberFormat()
            ->setFormatCode('DD/MM/YYYY'); // Formato de fecha: día/mes/año
    
        // Recorrer las filas para verificar el estado
        for ($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++) {
            // Obtener el valor de la celda en la columna 'Estado' (asumiendo que es la última columna)
            $estado = $sheet->getCellByColumnAndRow($highestColumnIndex, $rowIndex)->getValue();
    
            // Si el estado es "Terminado", pintar la fila de verde claro
            if (strtolower(trim($estado)) == 'terminado') {
                $sheet->getStyle('A' . $rowIndex . ':' . $highestColumn . $rowIndex)
                    ->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => $greenColor], // Color verde claro
                        ],
                    ]);
            }
        }
    
        return [];
    }
}    