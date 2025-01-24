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
        $datatable = (new EloquentDataTable($query))
        ->setRowId('id')
        ->editColumn('created_at', function (HHardware $h_hardware) {
            return date("d/m/Y H:i", strtotime($h_hardware->created_at));
        })
        ->editColumn('updated_at', function (HHardware $h_hardware) {
            return date("d/m/Y H:i", strtotime($h_hardware->updated_at));
        })
        ->editColumn('purchase_date', function (HHardware $h_hardware) {
            return date("d/m/Y", strtotime($h_hardware->purchase_date));
        })
        ->editColumn('is_active', function (HHardware $h_hardware) {
            return $h_hardware->is_active
                ? '<span class="badge badge-success mb-2 me-4">Sí</span>'
                : '<span class="badge badge-danger mb-2 me-4">No</span>';
        });
        $datatable->addColumn('action', function ($row) {
            return $this->getActions($row);
        })->rawColumns(["action", "is_active"]);
    
        $datatable->filter(function($query) {

            
            if(request('user_id') !== null){
                $query->where('h_hardwares.user_id', '=', request('user_id'));
            }

            if(request('h_device_type_id') !== null){
                $query->where('h_hardwares.h_device_type_id', '=', request('h_device_type_id'));
            }

            if(request('h_brand_id') !== null){
                $query->where('h_hardwares.h_brand_id', '=', request('h_brand_id'));
            }

            if(request('initial_purchase_date') !== null){
                $query->whereDate('h_hardwares.purchase_date', '>=', request('initial_purchase_date'));
            }
        
            if(request('final_purchase_date') !== null){
                $query->whereDate('h_hardwares.purchase_date', '<=', request('final_purchase_date'));
            }
           
           
		}, true);
    

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
                <a onclick="deleteRow(' . $row->id . ')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        
                </a>
            ';
        }
        
    
        if (auth()->user()->hasPermissions("h_hardwares.show")) {
            $result .= '
                <a href="' . route('h_hardwares.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                        <circle cx="12" cy="12" r="1"/>
                        <circle cx="18" cy="12" r="1"/>
                        <circle cx="24" cy="12" r="1"/>
                    </svg>
                </a>
            ';
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
            'companies.name as company_name',
            'branches.name as branch_name',
            )
            
        ->leftjoin('branches','h_hardwares.branch_id','=','branches.id')    
        ->leftjoin('companies','h_hardwares.company_id','=','companies.id') 
        ->leftJoin('h_device_types','h_hardwares.h_device_type_id','=','h_device_types.id')
        ->leftJoin('h_brands','h_hardwares.h_brand_id','=','h_brands.id')
        ->leftJoin('users','h_hardwares.user_id','=','users.id')
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
            ->title('Responsable'),

            Column::make('dev_name')
            ->title('Tipo'),

            Column::make('brand_name')
            ->title('Marca'),

            Column::make('purchase_date')
            ->title('Fecha compra'),

            Column::make('serial_number')
            ->title('Numero de serie'),

            Column::make('color')
            ->title('Color'),

            Column::make('branch_name')
            ->title('Sucursal'),

            Column::make('custom_serial_number')
            ->title('Numero de serie generado')
            ->searchable(true)
            ->orderable(true)
            ->printable(true),


            
            Column::make('is_active')
                ->title('Activo')
                ->searchable(false)
                ->orderable(false),

        ];

        if (auth()->user()->hasPermissions("h_hardwares.edit") ||
            auth()->user()->hasPermissions("h_hardwares.create") ||
            auth()->user()->hasPermissions("h_hardwares.destroy")||
            auth()->user()->hasPermissions("h_hardwares.show"))
            {
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
