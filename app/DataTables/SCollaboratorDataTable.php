<?php

namespace App\DataTables;

use App\Models\SCollaborator;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SCollaboratorDataTable extends DataTable
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
        ->editColumn('created_at', function(SCollaborator $role) {
            return date("d/m/Y H:i", strtotime($role->created_at));
        })
        ->editColumn('updated_at', function(SCollaborator $role) {
            return date("d/m/Y H:i", strtotime($role->updated_at));
        })
        ->editColumn('is_active', function(SCollaborator $role) {
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
        if (auth()->user()->hasPermissions("s_collaborators.edit")) {
            $result .= '
                <a title="Editar" href='.route("s_collaborators.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("s_collaborators.destroy")) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                </a>
            ';
        }
        return $result;
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SCollaborator $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SCollaborator $model): QueryBuilder
    {
        return $model->select(
            's_collaborators.*',
            'users.name as user_name',
            's_branches.name as branch_name',
        )
        ->leftJoin('users','s_collaborators.user_id','=','users.id')
        ->leftJoin('s_branches','s_collaborators.s_branch_id','=','s_branches.id')
        
        
        
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
                    ->setTableId('s_collaborators-table')
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
           
            Column::make('user_name')->title('Nombre')->name("users.name"),
            // ->searchable(true)
            // ->orderable(true)
            // ->printable(true),
            Column::make('commission_percentage')->title('Porcentaje de comisión'),
            Column::make('branch_name')->title('Sucursal')->name("s_branches.name"),
           
           
            Column::make('is_active')->title("Activo"),

        ];

        if (auth()->user()->hasPermissions("s_collaborators.edit") ||
            auth()->user()->hasPermissions("s_collaborators.create") ||
            auth()->user()->hasPermissions("s_collaborators.destroy")) {
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
        return 's_collaborators_' . date('YmdHis');
    }
}
