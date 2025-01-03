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

class SGeneralReportDataTable extends DataTable
{
    private $year = 2024;

    private $months = [
        "january" => "Enero",
        "february" => "Febrero",
        "march" => "Marzo",
        "april" => "Abril",
        "may" => "Mayo",
        "june" => "Junio",
        "july" => "Julio",
        "august" => "Agosto",
        "september" => "Septiembre",
        "october" => "Octubre",
        "november" => "Noviembre",
        "december" => "Diciembre",
    ];

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatable = (new EloquentDataTable($query));

        $datatable->editColumn('institution_name', function(SSale $sSale) {
            return '<p title="'.$sSale->institution_name.'">' . Str::limit($sSale->institution_name, 16, '...') . '</p>';
        });
        
        foreach ($this->months as $key => $value) {

            $datatable->editColumn($key, function(SSale $sSale) use ($key) {
                return number_format($sSale->$key, 2, ".", ",");
            });
        }

        $datatable->editColumn('total_by_institution', function(SSale $sSale) {
            return number_format($sSale->total_by_institution, 2, ".", ",");
        })->editColumn('percentage_of_total', function(SSale $sSale) {
            return number_format($sSale->percentage_of_total, 2, ".", ",")."%";
        });
        
        $datatable->rawColumns(["institution_name"]);

        $datatable->filter(function($query) {
           $this->year = request("year");
		}, true);
        
        return $datatable;
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
        $totalGlobal = DB::table('s_sales')
        ->whereYear('s_sales.grant_date', (request("year") ?? 2024))
        ->sum('s_sales.credit_amount'); // Sumar el total global

        return $model->select(
                'institutions.name as institution_name',
                DB::raw('
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 1 THEN s_sales.credit_amount ELSE 0 END) as january,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 2 THEN s_sales.credit_amount ELSE 0 END) as february,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 3 THEN s_sales.credit_amount ELSE 0 END) as march,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 4 THEN s_sales.credit_amount ELSE 0 END) as april,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 5 THEN s_sales.credit_amount ELSE 0 END) as may,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 6 THEN s_sales.credit_amount ELSE 0 END) as june,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 7 THEN s_sales.credit_amount ELSE 0 END) as july,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 8 THEN s_sales.credit_amount ELSE 0 END) as august,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 9 THEN s_sales.credit_amount ELSE 0 END) as september,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 10 THEN s_sales.credit_amount ELSE 0 END) as october,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 11 THEN s_sales.credit_amount ELSE 0 END) as november,
                    SUM(CASE WHEN MONTH(s_sales.grant_date) = 12 THEN s_sales.credit_amount ELSE 0 END) as december
                '),
                DB::raw('SUM(s_sales.credit_amount) as total_by_institution'),
                DB::raw('
                    (SUM(s_sales.credit_amount) / ?) * 100 as percentage_of_total
                ')
            )
            ->leftJoin('institutions', 's_sales.institution_id', '=', 'institutions.id')
            ->whereYear('s_sales.grant_date', (request("year") ?? 2024)) // Filtrar solo el año 2024
            ->groupBy('institutions.id', 'institutions.name') // Agrupar por institución
            ->addBinding($totalGlobal, 'select') // Agregar el total global como binding
            ->newQuery();
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
                    ->setTableId('s_general_reports-table')
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
        $columns = [
            Column::make('institution_name')->title('Institución')->name("institutions.name"),
        ];

        foreach ($this->months as $key => $value) {
            array_push($columns, Column::make($key)->title($value));
        }

        array_push($columns, Column::make('total_by_institution')->title('TOTAL GENERAL'));
        array_push($columns, Column::make('percentage_of_total')->title('PORCENTAJE'));

        

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'SGeneralReports_' . date('YmdHis');
    }
}
