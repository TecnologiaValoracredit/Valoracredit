<?php

namespace App\DataTables;

use App\Models\RIndicator;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RIndicatorFinalDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        
        $datatable = (new EloquentDataTable($query))->setRowId('institution_id')
        ->editColumn('days_0_30', function(RIndicator $rIndicator) {
            return "$".number_format($rIndicator->days_0_30, 2, ".", ",");
        })->editColumn('days_31_60', function(RIndicator $rIndicator) {
            return "$".number_format($rIndicator->days_31_60, 2, ".", ",");
        })->editColumn('days_61_90', function(RIndicator $rIndicator) {
            return "$".number_format($rIndicator->days_61_90, 2, ".", ",");
        })->editColumn('dias_91_120', function(RIndicator $rIndicator) {
            return "$".number_format($rIndicator->dias_91_120, 2, ".", ",");
        })->editColumn('dias_more_120', function(RIndicator $rIndicator) {
            return "$".number_format($rIndicator->dias_more_120, 2, ".", ",");
        })->editColumn('total', function(RIndicator $rIndicator) {
            return "$".number_format($rIndicator->dias_more_120, 2, ".", ",");
        });
        return $datatable;
    }

    public function getActions($row){
        $result = null;
        return $result;
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RIndicator $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RIndicator $model): QueryBuilder|Builder
    {
        $mes = request('month');
        $año = request('year');

        $query = $model->selectRaw("
            institutions.id AS id, institutions.name AS institution_name,
            SUM(CASE 
            WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 30 THEN r_indicators.matching_captial 
            ELSE 0 
            END) AS days_0_30,
            SUM(CASE 
            WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) > 30 AND DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 60 THEN r_indicators.matching_captial 
            ELSE 0 
            END) AS days_31_60,
            SUM(CASE 
            WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) > 60 AND DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 90 THEN r_indicators.matching_captial 
            ELSE 0 
            END) AS days_61_90,
            SUM(CASE 
            WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) > 90 AND DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 120 THEN r_indicators.matching_captial 
            ELSE 0 
            END) AS dias_91_120,
            SUM(CASE 
            WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) > 120 THEN r_indicators.matching_captial 
            ELSE 0 
            END) AS dias_more_120,
            SUM(r_indicators.matching_captial) AS total")
        ->when($mes && $año, function ($query) use ($mes, $año) {
            $query->whereMonth('upload_date', $mes)
            ->whereYear('upload_date', $año);
        })
        ->leftJoin('institutions', 'r_indicators.institution_id', '=', 'institutions.id')
        ->groupBy('institutions.id', 'institutions.name');

        return $query;
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
                        'paging' => false, 
                        'searching' => true,
                        'info' => true,
                        'responsive' => true,
                        "scrollX"=> true,
                    ])
                    ->setTableId('r_indicator_final-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
            Column::make('days_0_30')->title('0-30 días'),
            Column::make('days_31_60')->title('31-60 días'),
            Column::make('days_61_90')->title('61-90 días'),
            Column::make('dias_91_120')->title('91-120 días'),
            Column::make('dias_more_120')->title('Más de 120 días'),
            Column::make('total')->title('Total general'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'RIndicators_' . date('YmdHis');
    }
}
