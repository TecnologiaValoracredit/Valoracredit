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
    private $requisition;
    private $requisitionRow;
    private $is_show;
    public function __construct(Requisition $requisition, RequisitionRow $requisitionRow = null, $is_show = false)
	{
        $this->requisitionRow = $requisitionRow;
        $this->is_show = $is_show;
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
        $datatable = (new EloquentDataTable($query))
        ->setRowId('id')

        ->editColumn('product_cost', function ($row) {
            return '$' . number_format($row->product_cost, 2);
        })
        ->editColumn('total_cost', function ($row) {
            return '$' . number_format($row->total_cost, 2);
        })
        ->editColumn('has_iva', function ($row) {
            return $row->has_iva ? 'Sí' : 'No';
        })

        ->editColumn('created_at', function(RequisitionRow $role) {
            return date("d/m/Y H:i", strtotime($role->created_at));
        })
        ->editColumn('updated_at', function(RequisitionRow $role) {
            return date("d/m/Y H:i", strtotime($role->updated_at));
        })

        ->editColumn('application_date', function(RequisitionRow $role) {
            return date("d/m/Y", strtotime($role->updated_at));
        })

        ->editColumn('is_active', function(RequisitionRow $role) {
            if ($role->is_active) {
                return '<span class="badge badge-success mb-2 me-4">Sí</span>';
            }
            return '<span class="badge badge-danger mb-2 me-4">No</span>';
        });


        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "is_active"]);

        return $datatable;
    }

     public function getActions($row){
        $isShow = request()->get('is_show', false);

        $result = null;
        if(!$isShow){
            if (auth()->user()->hasPermissions("requisition_rows.edit")) {
                $result .= '
                    <button type="button" title="Editar" onclick="editModal('.$row->id.')" class="btn btn-outline-secondary btn-icon open-modal ps-2 px-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                    </button>
                ';
            }
            if (auth()->user()->hasPermissions("requisition_rows.destroy")) {
                $result .= '
                    <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                    </a>
                ';
            }
        }else{
            if (auth()->user()->hasPermissions("requisition_rows.show")) {
            $result .= 
                    '<button type="button" title="Show" onclick="showModal('.$row->id.')" class="btn btn-outline-secondary btn-icon open-modal" data-id="'.$row->id.'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                            <circle cx="10" cy="15" r="1"/>
                            <circle cx="16" cy="15" r="1"/>
                            <circle cx="22" cy="15" r="1"/>
                        </svg>
                    </button>';
             }
        }
            
        return $result;
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
            $query = $query->leftJoin('requisitions','requisition_rows.requisition_id','=','requisitions.id')
                    ->where('requisition_id', $this->requisition->id)
                    ->whereNull('parent_id'); 

        }
        if ($this->requisitionRow) {
            $query = $query->where('parent_id', $this->requisitionRow->id);
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
                        'retrieve'   => true,
                    ])
                    ->setTableId('requisition_rows-table')
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
            Column::make('product_cost')->title('Costo unitario'),
            Column::make('has_iva')->title('Incluye IVA'),
            Column::make('total_cost')->title('Total'),
           
           
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
