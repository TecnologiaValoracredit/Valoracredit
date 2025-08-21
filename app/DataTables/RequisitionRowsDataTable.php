<?php

namespace App\DataTables;

use App\Models\RequisitionRow;
use App\Models\Requisition;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RequisitionRowsDataTable extends DataTable
{
    public function __construct(Requisition $requisition)
	{
		$this->requisition = $requisition;
	}
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'requisitionrows.action')
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RequisitionRow $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RequisitionRow $model): QueryBuilder
    {
        $query = $model->select(
            'requisition_rows.*',
        )->newQuery();

        if($this->requisition){
            $query->leftJoin('requisitions','requisition_rows.requisition_id','=','requisitions.id');
        }

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
                        'paging' => true,
                        'searching' => true,
                        'info' => true,
                        'responsive' => true,
                        "scrollX"=> true,
                    ])
                    ->setTableId('s_promotors-table')
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
           
            Column::make('product')->title('Producto'),
            Column::make('product_quantity')->title('Cantidad'),
            Column::make('product_price')->title('Costo unitario'),
            Column::make('has_iva')->title('Incluye IVA'),
            Column::make('total')->title('Total'),
           
           
            // Column::make('is_active')->title("Activo"),

        ];

        if (auth()->user()->hasPermissions("requisitions.edit") ||
            auth()->user()->hasPermissions("requisitions.create") ||
            auth()->user()->hasPermissions("requisitions.destroy")) {
            $columns = array_merge($columns, [
                Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title('Acciones')
            ]);
        }

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'RequisitionRows_' . date('YmdHis');
    }
}
