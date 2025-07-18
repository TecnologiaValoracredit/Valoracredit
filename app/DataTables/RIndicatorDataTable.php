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

class RIndicatorDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatable = (new EloquentDataTable($query))->setRowId('id')
        ->editColumn('cut_date', function(RIndicator $rIndicator) {
            return $rIndicator->cut_date ? date("d/m/Y", strtotime($rIndicator->cut_date)) : 'Sin fecha';
        })
        ->editColumn('portfolio_date', function(RIndicator $rIndicator) {
            return $rIndicator->portfolio_date ? date("d/m/Y", strtotime($rIndicator->portfolio_date)) : 'Sin fecha';
        })
        ->editColumn('last_move_date', function(RIndicator $rIndicator) {
            return $rIndicator->last_move_date ? date("d/m/Y", strtotime($rIndicator->last_move_date)) : 'Sin fecha';
        })
        ->editColumn('upload_date', function(RIndicator $rIndicator) {
            return date("d/m/Y", strtotime($rIndicator->upload_date));
        })
        ->editColumn('matching_captial', function(RIndicator $rIndicator) {
            return "$".number_format($rIndicator->matching_captial, 2, ".", ",");
        })
        ->editColumn('total_portfolio', function(RIndicator $rIndicator) {
            return "$".number_format($rIndicator->total_portfolio, 2, ".", ",");
        })
        ->editColumn('days_diference', function (RIndicator $rIndicator) {

            return $this->getDiffDays($rIndicator);
        })
        ->editColumn('days_diference_range', function (RIndicator $rIndicator) {
            $days_diference = $this->getDiffDays($rIndicator);

            if ($days_diference <= 30) {
                return '0-30 Días';
            } elseif ($days_diference <= 60) {
                return '31-60 Días';
            } elseif ($days_diference <= 90) {
                return '61-90 Días';
            } elseif ($days_diference <= 120) {
                return '91-120 Días';
            } else {
                return '+120 Días';
            }
        })

        ->orderColumn('days_diference', function ($query, $direction) {
            $query->orderByRaw("DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) $direction");
        })->orderColumn('days_diference_range', function ($query, $direction) {
            $query->orderByRaw("
                CASE
                    WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 30 THEN 1
                    WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 60 THEN 2
                    WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 90 THEN 3
                    WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 120 THEN 4
                    ELSE 5
                END $direction
            ");
        })
        ->filterColumn('days_diference', function ($query, $keyword) {
            $query->whereRaw("DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) LIKE ?", ["%{$keyword}%"]);
        })
        ->filterColumn('days_diference_range', function ($query, $keyword) {
            $query->whereRaw("
                CASE
                    WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 30 THEN '0-30 Días'
                    WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 60 THEN '31-60 Días'
                    WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 90 THEN '61-90 Días'
                    WHEN DATEDIFF(cut_date, COALESCE(last_move_date, portfolio_date)) <= 120 THEN '91-120 Días'
                    ELSE '+120 Días'
                END LIKE ?", ["%{$keyword}%"]);
        });


        return $datatable;
    }

    private function getDiffDays(RIndicator $rIndicator){
        $cut_date = Carbon::parse($rIndicator->cut_date);
        if ($rIndicator->last_move_date === null) {
            $portfolio = Carbon::parse($rIndicator->portfolio_date);
            $days_diference = $cut_date->diffInDays($portfolio);
        }else {
            $last_move_date = Carbon::parse($rIndicator->last_move_date);
            $days_diference = $cut_date->diffInDays($last_move_date);
        }

        return $days_diference;
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
    public function query(RIndicator $model): QueryBuilder
    {
        $mes = request('month');
        $año = request('year');
        return $model->select(
			'r_indicators.*',
            'institutions.name as institution_name'
        )
        ->when($mes && $año, function ($query) use ($mes, $año) {
            $query->whereMonth('upload_date', $mes)
            ->whereYear('upload_date', $año);
        })
        ->leftjoin('institutions', 'r_indicators.institution_id', '=', 'institutions.id')
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
                        'paging' => true,
                        'searching' => true,
                        'info' => true,
                        'responsive' => true,
                        "scrollX"=> true,
                    ])
                    ->setTableId('r_indicator-table')
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
            Column::make('id')
            ->title('Id')
            ->searchable(false)
            ->visible(false),
            
            Column::make('credit_id')->title('# Crédito'),
            Column::make('institution_name')->title('Institución')->name("institutions.name"),
            Column::make('matching_captial')->title('Capital coinciliado'),
            Column::make('total_portfolio')->title('Total cartera'),
            Column::make('cut_date')->title('Fecha de corte'),
            Column::make('portfolio_date')->title('Fecha portafolio'),
            Column::make('last_move_date')->title('Fecha ult. mov.'),
            Column::make('upload_date')->title('Fecha subida'),
            Column::make('days_diference')->title('Dias diferencia'),
            Column::make('days_diference_range')->title('Rango'),      
        ];

        return $columns;
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
