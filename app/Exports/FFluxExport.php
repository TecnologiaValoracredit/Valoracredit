<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Carbon\Carbon;

class FFluxExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;
    protected $clasifications;
    protected $activeAccounts;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $clasifications, $activeAccounts, $startDate, $endDate)
    {
        $this->data = $data;
        $this->clasifications = $clasifications;
        $this->activeAccounts = $activeAccounts;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getTotalBalanceForDate($date)
    {
        $totalBalance = 0;

        // Iterar sobre cada cuenta y sumar el balance para la fecha específica
        foreach ($this->activeAccounts as $account) {
            $totalBalance += $account->getBalanceAttribute(null, $date); // Balance hasta el día anterior
        }

        return $totalBalance;
    }

    public function collection()
    {
        $rows = [];
    
        // Convertir las fechas a objetos Carbon
        $initialDate = Carbon::parse($this->startDate);
        $finalDate = Carbon::parse($this->endDate);

        // Crear un array con las fechas entre $startDate y $endDate
        $dates = [];
        for ($date = $initialDate; $date->lte($finalDate); $date->addDay()) {
            $dates[] = $date->format('d-m-y'); // Formato: "01-ene-25"
        }
    
        // Inicializar los totales de ingresos y egresos
        $totalIngresos = 0;
        $totalEgresos = 0;
    
        // Inicializar arrays para almacenar los totales diarios
        $totalesIngresosPorDia = array_fill_keys($dates, 0);
        $totalesEgresosPorDia = array_fill_keys($dates, 0);
    
        // Agregar la fila de balance inicial antes de la sección de "Ingresos"
        $balanceInicialRow = ['Clasificación' => 'SALDO INICIAL'];
        foreach ($dates as $key => $date) {
            $fechaAnterior = Carbon::createFromFormat('d-m-y', $date)->subDay()->format('d-m-y');
            $balanceInicial = $this->getTotalBalanceForDate($fechaAnterior);
            $balanceInicialRow[$date] = $balanceInicial;
        }
        $balanceInicialRow['Total'] = ''; // No aplica para esta fila
        $balanceInicialRow['% Participación'] = ''; // No aplica para esta fila
        $rows[] = $balanceInicialRow;
    
        // Sección de Ingresos (f_movement_type_id = 1)
        $rows[] = ['Ingresos']; // Encabezado de sección
        foreach ($this->clasifications as $clasification) {
            // Si es un padre con tipo de movimiento 1 (ingresos)
            if ($clasification->f_movement_type_id == 1 && !$clasification->parent_id) {
                $clasificationName = $clasification->name;
                $row = ['Clasificación' => $clasificationName];
                $total = 0; // Inicializar el total de la clasificación
    
                foreach ($dates as $date) {
                    $ingresos = $this->data[$clasificationName][$date][1] ?? 0; // 1 = Ingreso
                    $row[$date] = ($ingresos == 0) ? 0 : $ingresos;
                    $total += $ingresos; // Sumar al total
                    $totalesIngresosPorDia[$date] += $ingresos; // Sumar al total de ingresos por día (solo padres)
                }
    
                // Agregar el total y el porcentaje de participación al final de la fila
                $row['Total'] = $total;
                $row['% Participación'] = $this->data[$clasificationName]['% Participación'] ?? '0%'; // Usar el porcentaje ya calculado
                $rows[] = $row;
    
                // Sumar al total de ingresos
                $totalIngresos += $total;
    
                // Mostrar los hijos de esta clasificación (sin sumar a los totales diarios)
                foreach ($this->clasifications as $hijo) {
                    if ($hijo->parent_id == $clasification->id) {
                        $hijoName = $hijo->name . '-';
                        $rowHijo = ['Clasificación' => $hijoName];
                        $totalHijo = 0; // Inicializar el total del hijo
    
                        foreach ($dates as $date) {
                            $ingresosHijo = $this->data[$hijoName][$date][1] ?? 0; // 1 = Ingreso
                            $rowHijo[$date] = ($ingresosHijo == 0) ? 0 : $ingresosHijo;
                            $totalHijo += $ingresosHijo; // Sumar al total del hijo
                        }
    
                        // Agregar el total y el porcentaje de participación al final de la fila del hijo
                        $rowHijo['Total'] = $totalHijo;
                        $rowHijo['% Participación'] = $this->data[$hijoName]['% Participación'] ?? '0%'; // Usar el porcentaje ya calculado
                        $rows[] = $rowHijo;
                    }
                }
            }
        }
    
        // Agregar "Sin Clasificación" si existe y es de tipo ingreso
        if (isset($this->data['Sin Clasificación'])) {
            $row = ['Clasificación' => 'Sin Clasificación'];
            $total = 0; // Inicializar el total de "Sin Clasificación"
    
            foreach ($dates as $date) {
                $ingresos = $this->data['Sin Clasificación'][$date][1] ?? 0;
                $row[$date] = ($ingresos == 0) ? 0 : $ingresos;
                $total += $ingresos; // Sumar al total
                $totalesIngresosPorDia[$date] += $ingresos; // Sumar al total de ingresos por día
            }
    
            // Agregar el total y el porcentaje de participación al final de la fila
            $row['Total'] = $total;
            $row['% Participación'] = $this->data['Sin Clasificación']['% Participación'] ?? '0%'; // Usar el porcentaje ya calculado
            $rows[] = $row;
    
            // Sumar al total de ingresos
            $totalIngresos += $total;
        }
    
        // Agregar la fila de totales de ingresos por día
        $totalIngresosPorDiaRow = ['Clasificación' => 'Total Ingresos'];
        foreach ($dates as $date) {
            $totalIngresosPorDiaRow[$date] = $totalesIngresosPorDia[$date] ?? 0;
        }
        $totalIngresosPorDiaRow['Total'] = $totalIngresos; // Total de ingresos del mes
        $totalIngresosPorDiaRow['% Participación'] = ''; // No aplica para esta fila
        $rows[] = $totalIngresosPorDiaRow;
    
        // Agregar la fila de balance final antes de la sección de "egresos"
        $balanceFinalRow = ['Clasificación' => 'SALDO CON INGRESOS'];
        foreach ($dates as $key => $date) {
            $balanceInicial = $balanceInicialRow[$date] + $totalesIngresosPorDia[$date];
            $balanceFinalRow[$date] = $balanceInicial;
        }
        $balanceFinalRow['Total'] = ''; // No aplica para esta fila
        $balanceFinalRow['% Participación'] = ''; // No aplica para esta fila
        $rows[] = $balanceFinalRow;

        // Espacio entre secciones
        $rows[] = [''];
        $rows[] = ['Egresos']; // Encabezado de sección
    
        // Sección de Egresos (f_movement_type_id = 2)
        foreach ($this->clasifications as $clasification) {
            // Si es un padre con tipo de movimiento 2 (egresos)
            if ($clasification->f_movement_type_id == 2 && !$clasification->parent_id) {
                $clasificationName = $clasification->name;
                $row = ['Clasificación' => $clasificationName];
                $total = 0; // Inicializar el total de la clasificación
    
                foreach ($dates as $date) {
                    $egresos = $this->data[$clasificationName][$date][2] ?? 0; // 2 = Egreso
                    $row[$date] = ($egresos == 0) ? 0 : $egresos;
                    $total += $egresos; // Sumar al total
                    $totalesEgresosPorDia[$date] += $egresos; // Sumar al total de egresos por día (solo padres)
                }
    
                // Agregar el total y el porcentaje de participación al final de la fila
                $row['Total'] = $total;
                $row['% Participación'] = $this->data[$clasificationName]['% Participación'] ?? '0%'; // Usar el porcentaje ya calculado
                $rows[] = $row;
    
                // Sumar al total de egresos
                $totalEgresos += $total;
    
                // Mostrar los hijos de esta clasificación (sin sumar a los totales diarios)
                foreach ($this->clasifications as $hijo) {
                    if ($hijo->parent_id == $clasification->id) {
                        $hijoName = $hijo->name . '-';
                        $rowHijo = ['Clasificación' => $hijoName];
                        $totalHijo = 0; // Inicializar el total del hijo
    
                        foreach ($dates as $date) {
                            $egresosHijo = $this->data[$hijoName][$date][2] ?? 0; // 2 = Egreso
                            $rowHijo[$date] = ($egresosHijo == 0) ? 0 : $egresosHijo;
                            $totalHijo += $egresosHijo; // Sumar al total del hijo
                        }
    
                        // Agregar el total y el porcentaje de participación al final de la fila del hijo
                        $rowHijo['Total'] = $totalHijo;
                        $rowHijo['% Participación'] = $this->data[$hijoName]['% Participación'] ?? '0%'; // Usar el porcentaje ya calculado
                        $rows[] = $rowHijo;
                    }
                }
            }
        }
    
        // Agregar "Sin Clasificación" si existe y es de tipo egreso
        if (isset($this->data['Sin Clasificación'])) {
            $row = ['Clasificación' => 'Sin Clasificación'];
            $total = 0; // Inicializar el total de "Sin Clasificación"
    
            foreach ($dates as $date) {
                $egresos = $this->data['Sin Clasificación'][$date][2] ?? 0;
                $row[$date] = ($egresos == 0) ? 0 : $egresos;
                $total += $egresos; // Sumar al total
                $totalesEgresosPorDia[$date] += $egresos; // Sumar al total de egresos por día
            }
    
            // Agregar el total y el porcentaje de participación al final de la fila
            $row['Total'] = $total;
            $row['% Participación'] = $this->data['Sin Clasificación']['% Participación'] ?? '0%'; // Usar el porcentaje ya calculado
            $rows[] = $row;
    
            // Sumar al total de egresos
            $totalEgresos += $total;
        }
    
        // Agregar la fila de totales de egresos por día
        $totalEgresosPorDiaRow = ['Clasificación' => 'Total Egresos'];
        foreach ($dates as $date) {
            $totalEgresosPorDiaRow[$date] = $totalesEgresosPorDia[$date] ?? 0;
        }
        $totalEgresosPorDiaRow['Total'] = $totalEgresos; // Total de egresos del mes
        $totalEgresosPorDiaRow['% Participación'] = ''; // No aplica para esta fila
        $rows[] = $totalEgresosPorDiaRow;

        // Agregar la fila de SALDO FINAL DE DÍA antes de la sección de "Ingresos"
        $balanceFinalDiaRow = ['Clasificación' => 'SALDO FINAL DÍA'];
        foreach ($dates as $key => $date) {
            $balanceFinalDia = $this->getTotalBalanceForDate($date);
            $balanceFinalDiaRow[$date] = $balanceFinalDia;
        }
        $balanceFinalDiaRow['Total'] = ''; // No aplica para esta fila
        $balanceFinalDiaRow['% Participación'] = ''; // No aplica para esta fila
        $rows[] = $balanceFinalDiaRow;
    
        return collect($rows);
    }
    
    public function headings(): array
    {
        $headings = ['Clasificación'];
        $startDate = Carbon::parse($this->startDate); // Fecha de inicio
        $endDate = Carbon::parse($this->endDate); // Fecha de fin

        // Crear un array con los 31 días de enero en formato "dd-mmm-aa"
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('d/m/y'); // Formato: "01/01/25"
            $dates[] = $formattedDate; // Almacenar la fecha en el array de fechas
            $headings[] = $formattedDate; // Agregar la fecha a los encabezados
        }
    
        // Agregar las columnas "Total" y "% Participación" al final de los encabezados
        $headings[] = 'Total';
        $headings[] = '% Participación';
    
        return $headings;
    }

    public function styles(Worksheet $sheet)
    {
        function getNextColumn($col) {
            $length = strlen($col);
            $carry = true;
        
            for ($i = $length - 1; $i >= 0; $i--) {
                $char = $col[$i];
                if ($carry) {
                    if ($char === 'Z') {
                        $col[$i] = 'A';
                        $carry = true;
                    } else {
                        $col[$i] = ++$char;
                        $carry = false;
                    }
                }
            }
        
            if ($carry) {
                $col = 'A' . $col; // Si hay carry, agregamos una nueva letra (por ejemplo, Z -> AA)
            }
        
            return $col;
        }
        // Recorrer las clasificaciones para aplicar estilos
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->freezePane('B3');


        for ($colIndex = 2; $colIndex <= $highestColumnIndex; $colIndex++) {
            $col = Coordinate::stringFromColumnIndex($colIndex);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col . '1:' . $col . $sheet->getHighestRow())
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_USD); // Formato de contabilidad (USD)

            // Alinear el contenido a la derecha
            $sheet->getStyle($col . '1:' . $col . $sheet->getHighestRow())
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        }
      
        $sheet->getStyle('A1:' . $highestColumn . '1')
        ->applyFromArray([
            'font' => [
                'bold' => true, // Negritas
                'size' => 12,   // Tamaño de letra más grande
                'color' => ['argb' => 'FFFFFF'], // Color de letra (rojo en este caso)
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '221f7a'], // Fondo amarillo
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Centrar horizontalmente
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Centrar verticalmente
            ],
        ]);

        // Recorre todas las filas de la columna A
        for ($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++) {
            // Obtén el valor de la celda en la columna A y fila actual ($rowIndex)
            $cellValue = $sheet->getCell('A' . $rowIndex)->getValue();

            // Ignorar celdas vacías
            if (empty($cellValue)) {
                continue;
            }

           
            // Verifica si el valor termina con '-'
            if (str_ends_with($cellValue, '-')) {
                // Alinear a la derecha si termina con '-'
                $sheet->getStyle('A' . $rowIndex)->getAlignment()->setHorizontal('right');
            } else {
                // Aplicar negritas si no termina con '-'
                $sheet->getStyle('A' . $rowIndex . ':' . $highestColumn . $rowIndex)
                ->applyFromArray([
                    'font' => [
                        'bold' => true, // Negritas
                        'size' => 12,   // Tamaño de letra más grande
                        'color' => ['argb' => '000000'], // Color de letra (rojo en este caso)
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'b0cef5'], 
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Centrar verticalmente
                    ],
                ]);   
            }

            if (strtolower(trim($cellValue)) == 'ingresos' || strtolower(trim($cellValue)) == 'egresos') {
                // Unir todas las columnas de la fila actual
                $sheet->mergeCells('A' . $rowIndex . ':' . $highestColumn . $rowIndex);
        
                // Pintar el fondo de la celda unida de otro color (por ejemplo, amarillo)
                $sheet->getStyle('A' . $rowIndex . ':' . $highestColumn . $rowIndex)
                ->applyFromArray([
                    'font' => [
                        'bold' => true, // Negritas
                        'size' => 16,   // Tamaño de letra más grande
                        'color' => ['argb' => 'FFFFFF'], // Color de letra (rojo en este caso)
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => '0d155c'], // Fondo amarillo
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Centrar verticalmente
                    ],
                ]);
            }

            if (strtolower(trim($cellValue)) == 'total ingresos' || strtolower(trim($cellValue)) == 'total egresos') {
                // Pintar el fondo de la celda unida de otro color (por ejemplo, amarillo)
                $sheet->getStyle('A' . $rowIndex . ':' . $highestColumn . $rowIndex)
                ->applyFromArray([
                    'font' => [
                        'bold' => true, // Negritas
                        'size' => 14,   // Tamaño de letra más grande
                        'color' => ['argb' => '000000'], // Color de letra (rojo en este caso)
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'ededb4'], // Fondo amarillo
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, // Centrar verticalmente
                    ],
                ]);
            }
        }
        // Pintar la columna "Total"
        $totalMesColumn = Coordinate::stringFromColumnIndex($highestColumnIndex - 1); // Columna "Total"
        $sheet->getStyle($totalMesColumn . '1:' . $totalMesColumn . $highestRow)
        ->applyFromArray([
            'font' => [
                'size' => 14,   // Tamaño de letra más grande
                'color' => ['argb' => '000000'], 
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'ededb4'], // Fondo amarillo
            ],
        ]);

        return [];
    }
}
