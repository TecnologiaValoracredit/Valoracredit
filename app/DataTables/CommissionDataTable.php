<?php

namespace App\DataTables;

use App\Models\Commission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CommissionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatable = (new EloquentDataTable($query))
        ->setRowId('id')
        ->editColumn('grant_date', function(Commission $commission) {
            return date("d/m/Y", strtotime($commission->sSale->grant_date));
        })
        ->editColumn('created_at', function(Commission $commission) {
            return date("d/m/Y H:i", strtotime($commission->created_at));
        })
        ->editColumn('updated_at', function(Commission $commission) {
            return date("d/m/Y H:i", strtotime($commission->updated_at));
        })
        ->editColumn('beneficiary_type', function(Commission $commission) {
            return $commission->user->user_type;
        })
        ->editColumn('credit_amount', function(Commission $commission) {
            return '$' . number_format($commission->credit_amount, 2, '.', ',');
        })
        ->editColumn('opening_amount', function(Commission $commission) {
            return '$' . number_format($commission->opening_amount, 2, '.', ',');
        })
        ->editColumn('amount_received', function(Commission $commission) {
            return '$' . number_format($commission->amount_received, 2, '.', ',');
        })
        ->editColumn('is_active', function(Commission $commission) {
            if ($commission->is_active) {
                return '<span class="badge badge-success mb-2 me-4">Sí</span>';
            }
            return '<span class="badge badge-danger mb-2 me-4">No</span>';
        })->rawColumns(["is_active"]);

         $datatable->filter(function($query) {
            if(request('initial_date') !== null){
                $query->whereDate('s_sales.grant_date', '>=', request('initial_date'));
            }
            
            if(request('final_date') !== null){
                $query->whereDate('s_sales.grant_date', '<=', request('final_date'));
            }
            
		}, true);

        return $datatable;
    }

    public function getActions($row){
        
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Commission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Commission $model): QueryBuilder
    {
        return $model->select(
            'commissions.*',
            'users.name as user_name',
            's_sales.*'
        )
        ->leftJoin('users','commissions.user_id','=','users.id')
        ->leftJoin('s_sales','commissions.s_sale_id','=','s_sales.id')
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
                        'responsive' => true, // Habilitar responsividad
                        'scrollX' =>true,
                        'info' => true,
                    ])
                    ->setTableId('commissions-table')
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
            Column::make('grant_date')->title('Fecha'),
            Column::make('user_name')->title('Beneficiario')->name("user_name"),
            Column::make('beneficiary_type')->title('Tipo')->searchable(false),
            Column::make('credit_id')->title('# Crédito'),
            Column::make('credit_amount')->title('Venta'),
            Column::make('opening_amount')->title('Monto entregado'),
            Column::make('commission_percentage')->title('% comisión'),
            Column::make('amount_received')->title('Comisión'),

            Column::make('created_at')->visible(true)->searchable(false)->title('Fecha creado'),
            Column::make('updated_at')->visible(false)->searchable(false)->title('Fecha editado'),
            Column::make('is_active')->title("Activo"),

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
        return 'Commissions_' . date('YmdHis');
    }
}
