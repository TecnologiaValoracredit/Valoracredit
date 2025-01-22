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

class SCoordinatorReportDataTable extends DataTable
{
    private $year = 2025;


    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatable = (new EloquentDataTable($query));

        
        $datatable->editColumn('total_by_coordinator', function(SSale $sSale) {
            return number_format($sSale->total_by_coordinator, 2, ".", ",");
        });
        
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
        $data = $model
            ->select(
                's_coordinators.name as coordinator_name',
                DB::raw('SUM(s_sales.credit_amount) as total_by_coordinator'),
            )
            ->leftJoin('s_coordinators', 's_sales.s_coordinator_id', '=', 's_coordinators.id')
            ->whereYear('s_sales.grant_date', (request('year') ?? 2025)) // Filtrar solo por el año solicitado
            ->groupBy('s_coordinators.id', 's_coordinators.name') // Agrupar por coordinador
            ->newQuery();

        return $data;
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
                    ->setTableId('s_coordinator_reports-table')
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
            Column::make('coordinator_name')->title('Coordinador')->name("s_coordinators.name"),
            Column::make('total_by_coordinator')->title('Total'),

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
        return 'SCoordinatorReport_' . date('YmdHis');
    }
}
