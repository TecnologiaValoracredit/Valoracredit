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

class SSaleDataTable extends DataTable
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
        ->editColumn('created_at', function(SSale $sSale) {
            return date("d/m/Y H:i", strtotime($sSale->created_at));
        })
        ->editColumn('updated_at', function(SSale $sSale) {
            return date("d/m/Y H:i", strtotime($sSale->updated_at));
        })
        ->editColumn('grant_date', function(SSale $sSale) {
            return date("d/m/Y", strtotime($sSale->grant_date));
        })
        ->editColumn('credit_amount', function(SSale $sSale) {
            return "$".number_format($sSale->credit_amount, 2, ".", ",");
        })
        ->editColumn('opening_amount', function(SSale $sSale) {
            return "$".number_format($sSale->opening_amount, 2, ".", ",");
        })
        ->editColumn('total_amount', function(SSale $sSale) {
            return "$".number_format($sSale->total_amount, 2, ".", ",");
        });


        $datatable->filter(function($query) {
            if(request('initial_grant_date') !== null){
				$query->whereDate('s_sales.grant_date', '>=', request('initial_grant_date'));
			}

            if(request('final_grant_date') !== null){
				$query->whereDate('s_sales.grant_date', '<=', request('final_grant_date'));
			}
           
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
        return $model->select(
			's_sales.*',
            's_statuses.name as s_status_name',
            's_branches.name as s_branch_name',
			'institutions.name as institution_name',
            'coordinator_users.name as coordinator_name',
            'promotor_users.name as promotor_name',


		)
        ->leftjoin('s_statuses', 's_sales.s_status_id', '=', 's_statuses.id')
        ->leftjoin('s_branches', 's_sales.s_branch_id', '=', 's_branches.id')
        ->leftjoin('institutions', 's_sales.institution_id', '=', 'institutions.id')
        ->leftjoin('s_coordinators', 's_sales.s_coordinator_id', '=', 's_coordinators.id')
        ->leftJoin('users as coordinator_users', 's_coordinators.user_id', '=', 'coordinator_users.id')
        ->leftjoin('s_promotors', 's_sales.s_promotor_id', '=', 's_promotors.id')
        ->leftJoin('users as promotor_users', 's_promotors.user_id', '=', 'promotor_users.id')

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
                    ->setTableId('s_sales-table')
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
            Column::make('client_name')->title('Cliente'),
            Column::make('credit_amount')->title('Monto entregado'),
            Column::make('opening_amount')->title('Monto apertura'),
            Column::make('total_amount')->title('Monto total'),
            Column::make('grant_date')->title('F. Otorgamiento'),
            Column::make('institution_name')->title('Institución')->name("institutions.name"),
            Column::make('coordinator_name')->title('Coordinador')->name("coordinator_users.name"),
            Column::make('promotor_name')->title('Promotor')->name("promotor_users.name"),

            Column::make('s_branch_name')->title('Sucursal')->name("s_branches.name"),
            Column::make('s_status_name')->title('Estatus')->name("s_statuses.name"),

            Column::make('created_at')->searchable(false)->title('Fecha creado')->visible(false),
            Column::make('updated_at')->searchable(false)->title('Fecha editado')->visible(false),

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
        return 'SSales_' . date('YmdHis');
    }
}
