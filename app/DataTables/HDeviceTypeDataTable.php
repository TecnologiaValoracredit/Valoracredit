<?php

namespace App\DataTables;

use App\Models\HDeviceType;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HDeviceTypeDataTable extends DataTable
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
        ->editColumn('created_at', function (HDeviceType $h_device_type) {
            return date("d/m/Y H:i", strtotime($h_device_type->created_at));
        })
        ->editColumn('updated_at', function (HDeviceType $h_device_type) {
            return date("d/m/Y H:i", strtotime($h_device_type->updated_at));
        })
        ->editColumn('purchase_date', function (HDeviceType $h_device_type) {
            return date("d/m/Y", strtotime($h_device_type->purchase_date));
        })
        ->editColumn('is_active', function (HDeviceType $h_device_type) {
            return $h_device_type->is_active
                ? '<span class="badge badge-success mb-2 me-4">Sí</span>'
                : '<span class="badge badge-danger mb-2 me-4">No</span>';
        });
        $datatable->addColumn('action', function ($row) {
            return $this->getActions($row);
        })->rawColumns(["action", "is_active"]);
    

        return $datatable;   
    }
        
    

    public function getActions($row){

        $result = null;
    
        // Botón de edición
        if (auth()->user()->hasPermissions("h_device_types.edit")) {
            $result .= '
                <a title="Editar" href="'.route("h_device_types.edit", $row->id).'" class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                    </svg>
                </a>
            ';
        }
    
        // Botón de eliminación
        if (auth()->user()->hasPermissions("h_device_types.destroy")) {
            $result .= '
                <a onclick="deleteRow(' . $row->id . ')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        
                </a>
            ';
        }

        return $result;
 
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\HDeviceType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(HDeviceType $model): QueryBuilder
    {
        return $model->newQuery();
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
                    ])
                    ->setTableId('h_device_types-table')
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
            Column::make('name')
            ->title('Nombre')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),

            Column::make('is_active')
            ->title('Activo')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),
            
        ];

        if (auth()->user()->hasPermissions("h_device_types.edit") ||
        auth()->user()->hasPermissions("h_device_types.create") ||
        auth()->user()->hasPermissions("h_device_types.destroy")||
        auth()->user()->hasPermissions("h_device_types.show"))
        {
        $columns = array_merge($columns, [
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center')
            ->title('Acciones')
        ]);
        
        return $columns;
    }
}

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'h_device_types_' . date('YmdHis');
    }
}
