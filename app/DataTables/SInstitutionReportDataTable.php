<?php

namespace App\DataTables;

use App\Models\SSale;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SInstitutionReportDataTable extends DataTable
{
    private $months = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre',
    ];

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('total', function ($row) {
                return number_format($row->total, 2, ".", ","); // Formatear el total
            })
            ->editColumn('month', function ($row) {
                return $this->months[$row->month] ?? ucfirst($row->month); // Convertir el mes al español
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SSale $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SSale $model): QueryBuilder
    {
        $institutionName = request('institution_name'); // Obtener el nombre de la institución

        // Validar que se haya proporcionado un nombre de institución
        if (!$institutionName) {
            throw new \InvalidArgumentException("Se requiere un nombre de institución para el filtro.");
        }

        return $model->selectRaw('
                MONTHNAME(grant_date) as month, 
                SUM(credit_amount) as total
            ')
            ->join('institutions', 's_sales.institution_id', '=', 'institutions.id') // Relación con la tabla de instituciones
            ->where('institutions.name', $institutionName) // Filtrar por nombre de institución
            ->groupByRaw('MONTH(grant_date), MONTHNAME(grant_date)') // Agrupar por mes
            ->orderByRaw('MONTH(grant_date)'); // Ordenar por número de mes
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters([
                'stripeClasses' => ['row-even', 'row-odd'],
                'paging' => false,
                'searching' => false,
                'info' => true,
                'responsive' => true,
                'scrollX' => true
            ])
            ->setTableId('s_institution_reports-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, "asc")
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('month')->title('Mes'),
            Column::make('total')->title('Total Ventas'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'SInstitutionReports_' . date('YmdHis');
    }
}
