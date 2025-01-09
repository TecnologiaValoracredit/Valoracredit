<?php

namespace App\DataTables;

use App\Models\HHardware;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class HHardwareDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatable = (new EloquentDataTable($query));
        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "is_active"]);
        return $datatable;
    }
        
    

    public function getActions($row)
    {
        $result = null;
    
        // Botón de edición
        if (auth()->user()->hasPermissions("h_hardwares.edit")) {
            $result .= '
                <a title="Editar" href="'.route("h_hardwares.edit", $row->id).'" class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                    </svg>
                </a>
            ';
        }
    
        // Botón de eliminación
        if (auth()->user()->hasPermissions("h_hardwares.destroy")) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    </svg>
                </a>
            ';
        }
    


        // Botón de ver imagen (ojo)
        if ($row->image) {
            $result .= '
                <a href="javascript:void(0);" class="btn btn-outline-info btn-icon ps-2 px-1" data-bs-toggle="modal" data-bs-target="#imageModal'.$row->id.'" title="Ver imagen">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </a>
    
                <!-- Modal para mostrar la imagen -->
                <div class="modal fade" id="imageModal'.$row->id.'" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Imagen de Hardware</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="'.asset('storage/'.$row->image).'" alt="Imagen del hardware" class="img-fluid" />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        } else {
            // Si no hay imagen, muestra un texto "No disponible"
            $result .= '<span class="text-muted">No imagen</span>';
        }
    
        return $result;
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\HHardware $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(HHardware $model): QueryBuilder
    {
        return $model->select(
            
            'h_hardwares.*',
            'users.name as user_name',
            'h_device_types.name as dev_name',
            'h_brands.name as brand_name',
            )
            
        ->leftJoin('h_device_types','h_hardwares.h_device_type_id','=','h_device_types.id')
        ->leftJoin('h_brands', 'h_hardwares.h_brand_id', '=', 'h_brands.id')
        ->leftJoin('users', 'h_hardwares.user_id', '=', 'users.id')
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
                    ])
                    ->setTableId('h_hardwares-table')
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

            Column::make('user_name')
            ->title('Responsable')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),

            Column::make('dev_name')
            ->title('Tipo')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),

            Column::make('brand_name')
            ->title('Marca')
            ->searchable(true)
            ->orderable(false)
            ->className('text-wrap')
            ->printable(true),

            Column::make('purchase_date')
            ->title('Fecha compra')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),

            Column::make('serial_number')
            ->title('Numero de serie')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),

            Column::make('color')
            ->title('Color')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),

            Column::make('custom_serial_number')
            ->title('Numero de serie generado')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),


            
            Column::make('is_active')->title("Activo"),

        ];

        if (auth()->user()->hasPermissions("h_hardwares.edit") ||
            auth()->user()->hasPermissions("h_hardwares.create") ||
            auth()->user()->hasPermissions("h_hardwares.destroy")) {
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
        return 'h_hardwares_' . date('YmdHis');
    }
}
