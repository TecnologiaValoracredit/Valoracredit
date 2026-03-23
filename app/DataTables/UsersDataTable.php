<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
        ->editColumn('created_at', function($row) {
            return date("d/m/Y H:i", strtotime($row->created_at));
        })
        ->editColumn('updated_at', function($row) {
            return date("d/m/Y H:i", strtotime($row->updated_at));
        })
        ->editColumn('is_active', function($row) {
            $user = User::find($row->id);
            if (!$user->is_active || !$user->role->is_active) {
                return '<span class="badge badge-danger mb-2 me-4">No</span>';
            }
            return '<span class="badge badge-success mb-2 me-4">Sí</span>';
        });

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "is_active"]);

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model): QueryBuilder
    {
        return $model->select(
			'users.id',
            'users.name',
			'users.email',
			'users.created_at',
            'users.updated_at',
			'users.is_active',
			'roles.name as role_id',
            'departaments.name as departament_id',
		)
        ->leftjoin('departaments', 'users.departament_id', '=', 'departaments.id')
		->leftjoin('roles', 'users.role_id', '=', 'roles.id')
		->newQuery();
    }

    public function getActions($row){
        $result = null;
        if (auth()->user()->hasPermissions("users.edit")) {
            $result .= '
                <a title="Editar" href='.route("users.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("users.destroy") && $row->is_active) {
            $result .= '
                <a href="'.route("users.delete", $row->id).'" title="Baja" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M136 192C136 125.7 189.7 72 256 72C322.3 72 376 125.7 376 192C376 258.3 322.3 312 256 312C189.7 312 136 258.3 136 192zM48 546.3C48 447.8 127.8 368 226.3 368L285.7 368C384.2 368 464 447.8 464 546.3C464 562.7 450.7 576 434.3 576L77.7 576C61.3 576 48 562.7 48 546.3zM472 232L616 232C629.3 232 640 242.7 640 256C640 269.3 629.3 280 616 280L472 280C458.7 280 448 269.3 448 256C448 242.7 458.7 232 472 232z"/></svg>                </a>
            ';
        }
        if (auth()->user()->hasPermissions("users.show")) {
            $result .= '
                <a href="'. route('users.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon ps-2 px-1">
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
                        'responsive' => true, // Habilitar responsividad
                        'scrollX' =>true
                        
                    ])
                    ->setTableId('users-table')
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
            Column::make('role_id')->title("Rol"),
            Column::make('departament_id')->title("Depto."),
            Column::make('name')->title("Nombre"),
            Column::make('email')->title("Email"),
            Column::make('created_at')->searchable(false)->title("Fecha creado"),
            Column::make('updated_at')->searchable(false)->title("Fecha editado"),
            Column::make('is_active')->title("Activo"),
        ];

        $columns = array_merge($columns, [
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center')
            ->title("Acciones")
        ]);

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
