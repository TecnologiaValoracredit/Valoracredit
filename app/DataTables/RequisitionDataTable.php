<?php

namespace App\DataTables;

use App\Models\Requisition;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RequisitionDataTable extends DataTable
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
        ->editColumn('created_at', function(Requisition $role) {
            return date("d/m/Y H:i", strtotime($role->created_at));
        })
        ->editColumn('updated_at', function(Requisition $role) {
            return date("d/m/Y H:i", strtotime($role->updated_at));
        })

        ->editColumn('application_date', function(Requisition $role) {
            return date("d/m/Y", strtotime($role->updated_at));
        })

        ->editColumn('is_active', function(Requisition $role) {
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
        $result = null;
        if (auth()->user()->hasPermissions("requisitions.edit")) {
            $result .= '
                <a title="Editar" href='.route("requisitions.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("requisitions.destroy")) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                </a>
            ';
        }

        if (auth()->user()->hasPermissions("requisitions.show")) {
            $result .= '
                <a href="' . route('requisitions.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon ps-2 px-1">
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
     * @param \App\Models\Requisition $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Requisition $model): QueryBuilder
{
    return $model->newQuery()
        ->select([
            'requisitions.*',
            'users.name as created_by_name',  // Cambiar esto por 'users.name' para mostrar el nombre
            \DB::raw('COALESCE(SUM(requisition_rows.unit_price), 0) as total_ammount')
        ])
        ->leftJoin('users', 'users.id', '=', 'requisitions.created_by')  // Asegúrate de usar el campo correcto
        ->leftJoin('requisition_rows', 'requisition_rows.requisition_id', '=', 'requisitions.id')
        ->groupBy([
            'requisitions.id',
            'users.name',  // Esta es la columna de nombre que viene de la tabla `users`
            'requisitions.requisition_status_id',
            'requisitions.is_active',
            'requisitions.created_at',
            'requisitions.updated_at',
            'requisitions.payment_type_id',
            'requisitions.departament_id',
            'requisitions.branch_id',
            'requisitions.application_date',
            'requisitions.inmediate_boss_user_id',
            'requisitions.administration_user_id',
            'requisitions.general_direction_user_id',
            'requisitions.is_approved_inmediante_boss',
            'requisitions.is_approved_administration',
            'requisitions.is_approved_general_direction',
            'requisitions.created_by',  
            'requisitions.updated_by',
            'requisitions.notes',
            'requisitions.user_id'
        ]);
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
                    ->setTableId('requisitions-table')
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

            Column::make('id')->searchable(false)->title('Id'),
            Column::make('created_by_name')->searchable(false)->title('Creada por'),
            Column::make('application_date')->searchable(false)->title('Fecha creado'),
            Column::make('is_active')->title("Activo"),

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
        return 'Requisition_' . date('YmdHis');
    }
}

