<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class FFluxExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $clasifications;

    public function __construct($data, $clasifications)
    {
        $this->data = $data;
        $this->clasifications = $clasifications;
    }

    public function collection()
    {
        $rows = [];

        // Crear un array con los 31 días de enero en formato "dd-mmm-aa"
        $dates = [];
        for ($day = 1; $day <= 31; $day++) {
            $date = Carbon::create(2025, 1, $day)->format('d-m-y'); // Formato: "01-ene-25"
            $dates[] = $date;
        }

        // Sección de Ingresos
        $rows[] = ['Ingresos']; // Encabezado de sección
        foreach ($this->clasifications as $clasification) {
            $clasificationName = $clasification->name;

            // Si es un hijo, agregar un sufijo para diferenciarlo del padre
            if ($clasification->parent_id) {
                $clasificationName .= '-';
            }

            $row = ['Clasificación' => $clasificationName];

            foreach ($dates as $date) {
                $ingresos = $this->data[$clasificationName][$date][1] ?? 0; // 1 = Ingreso
                $row[$date . ' Ingresos'] = ($ingresos == 0) ? '$-' : $ingresos;
            }

            $rows[] = $row;
        }

        // Agregar "Sin Clasificación" si existe
        if (isset($this->data['Sin Clasificación'])) {
            $row = ['Clasificación' => 'Sin Clasificación'];

            foreach ($dates as $date) {
                $ingresos = $this->data['Sin Clasificación'][$date][1] ?? 0;
                $row[$date . ' Ingresos'] = ($ingresos == 0) ? '$-' : $ingresos;
            }

            $rows[] = $row;
        }

        // Espacio entre secciones
        $rows[] = [''];
        $rows[] = ['Egresos']; // Encabezado de sección

        // Sección de Egresos
        foreach ($this->clasifications as $clasification) {
            $clasificationName = $clasification->name;

            // Si es un hijo, agregar un sufijo para diferenciarlo del padre
            if ($clasification->parent_id) {
                $clasificationName .= '-';
            }

            $row = ['Clasificación' => $clasificationName];

            foreach ($dates as $date) {
                $egresos = $this->data[$clasificationName][$date][2] ?? 0; // 2 = Egreso
                $row[$date . ' Egresos'] = ($egresos == 0) ? '$-' : $egresos;
            }

            $rows[] = $row;
        }

        // Agregar "Sin Clasificación" si existe
        if (isset($this->data['Sin Clasificación'])) {
            $row = ['Clasificación' => 'Sin Clasificación'];

            foreach ($dates as $date) {
                $egresos = $this->data['Sin Clasificación'][$date][2] ?? 0;
                $row[$date . ' Egresos'] = ($egresos == 0) ? '$-' : $egresos;
            }

            $rows[] = $row;
        }

        return collect($rows);
    }

    public function headings(): array
    {
        $headings = ['Clasificación'];

        // Crear un array con los 31 días de enero en formato "dd-mmm-aa"
        $dates = [];
        for ($day = 1; $day <= 31; $day++) {
            $date = Carbon::create(2025, 1, $day)->format('d-m-y'); // Formato: "01-ene-25"
            $headings[] = $date;
        }

        return $headings;
    }
}
