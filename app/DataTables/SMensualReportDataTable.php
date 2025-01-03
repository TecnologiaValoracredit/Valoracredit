<?php

namespace App\DataTables;

use App\Models\SSale;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 


class SMensualReportDataTable extends DataTable
{
   

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $currentMonth = request('month') ?? now()->month;

        // Filtrar los resultados por mes seleccionado
        $query->whereMonth('s_sales.grant_date', $currentMonth);
    
        return (new EloquentDataTable($query))
            ->editColumn('total_monthly', function ($row) {
                return number_format($row->total_monthly, 2, ".", ","); // Formatear los meses
            })
            ->editColumn('total_sales', function ($row) {
                return number_format($row->total_sales, 0, ".", ","); // Formatear el número de ventas
            })
            ->editColumn('percentage_of_total', function ($row) {
                return number_format($row->percentage_of_total, 2, ".", ",") . "%"; // Formatear el porcentaje
            });
            
    }

    public function getActions($row){
        $result = null;
        return $result;
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SSale $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SSale $model): QueryBuilder
    {

    $currentMonth = request('month') ?? now()->month; // Mes actual o el enviado en la solicitud
    $currentYear = request('year') ?? now()->year;   // Año actual o el enviado en la solicitud
    
     // Obtener el total global de ventas para el mes actual
     $totalGlobal = DB::table('s_sales')
     ->whereYear('s_sales.grant_date', $currentYear) // Filtrar por año actual
     ->whereMonth('s_sales.grant_date', $currentMonth) // Filtrar por mes actual
     ->sum('s_sales.credit_amount'); // Sumar el monto total de ventas

     

    return $model->select(
            'institutions.name as institution_name',
            DB::raw('SUM(s_sales.credit_amount) as total_monthly'), // Total del mes actual
            DB::raw('COUNT(s_sales.id) as total_sales'), // Contar el número de venta
            DB::raw('(SUM(s_sales.credit_amount) / ?) * 100 as percentage_of_total') // Calcular el porcentaje de ventas por institución
        )
        ->leftJoin('institutions', 's_sales.institution_id', '=', 'institutions.id')
        ->whereYear('s_sales.grant_date', $currentYear) // Filtrar por año actual
        ->whereMonth('s_sales.grant_date', $currentMonth) // Filtrar por mes actual
        ->groupBy('institutions.id', 'institutions.name') // Agrupar por institución
        ->addBinding($totalGlobal, 'select') // Agregar el total global como binding para calcular el porcentaje
        ->orderBy('institutions.name');
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
                    ->setTableId('s_mensual_reports-table')
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
            Column::make('institution_name')->title('Institución'),
            Column::make('total_monthly')->title('Total del Mes'),
            Column::make('total_sales')->title('Total de Ventas'),
            Column::make('percentage_of_total')->title('Porcentaje de Ventas'), 
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'SMensualReports_' . date('YmdHis');
    }
}
