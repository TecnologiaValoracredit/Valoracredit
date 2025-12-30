<?php

namespace App\DataTables;

use App\Models\Permit;
use App\Models\PermitStatus;
use GuzzleHttp\Psr7\LimitStream;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use NoRewindIterator;
use Ramsey\Collection\Map\NamedParameterMap;
use SimpleXMLElement;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PermitDataTable extends DataTable
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
        ->editColumn('permit_date', function(Permit $permit) {
            return date("d/m/Y", strtotime($permit->permit_date));
        })
        ->editColumn('permit_status_name', function ($row){
            return '<span class="badge '. $row->permit_status_color . '">' . 
            $row->permit_status_name . '</span>';
        });

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "permit_status_name"]);

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Permit $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Permit $model): QueryBuilder
    {
        $query = $model->newQuery()
        ->select(
            'permits.id',
            'users.name as permit_user_name',
            'permits.user_id',
            'departaments.name as departament_id',
            'motives.name as motive_id',
            'permits.permit_date',
            'permit_statuses.name as permit_status_name',
            'permit_statuses.color as permit_status_color',
            'permits.boss_id',
            'permits.is_active',
            'permits.is_signed_by_hr',
            'permits.is_signed_by_boss',
        )
        ->leftjoin('users', 'permits.user_id', '=', 'users.id')
        ->leftjoin('departaments', 'permits.departament_id', '=', 'departaments.id')
        ->leftjoin('motives', 'permits.motive_id', '=', 'motives.id')
        ->leftJoin('permit_statuses', 'permits.permit_status_id', '=', 'permit_statuses.id')
        ->where('permits.is_active', 1);

        if (auth()->user()->hasPermissions('permits.seeAllPermits')){
            return $query;
        }
        else if (auth()->user()->hasPermissions('permits.seeUserPermits'))
        {
            return $query->where('permits.user_id', auth()->id())
            ->orWhere('permits.boss_id', auth()->id());
        }
        else{
            return $query->newQuery();
        }
    }

    public function getActions($row){
        $result = null;
        $isHr = auth()->user()->hasPermissions('permits.seeAllPermits');
        $signature = 'is_signed_by_' . ($isHr ? 'hr' : 'boss');


        //Solo se puede editar SI es el mismo usuario del permiso Y si solamente ha sido creado el permiso sin mandar
        if ((auth()->user()->hasPermissions("permits.edit") && auth()->id() == $row->user_id) && ($row->permit_status_name == "Creado")) {
            $result .= '
                <a title="Editar" href='.route("permits.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("permits.show")) {
            $result .= '
                <a href="'. route('permits.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                        <circle cx="12" cy="12" r="1"/>
                        <circle cx="18" cy="12" r="1"/>
                        <circle cx="24" cy="12" r="1"/>
                    </svg>
                </a>
            ';
        }
        //Solo puede cambiar el estatus SI es el jefe O RH Y el permiso no ha sido aprobado/denegado Y si no ha autorizado
        if ((auth()->user()->hasPermissions("permits.seeAllPermits") || auth()->id() == $row->boss_id) && (in_array($row->permit_status_name, ["Enviado", "En revisión"])) && !$row->$signature) {
            $result .= '
                <a href="'.route('permits.changePermitStatus', $row->id).'" title="Cambiar estatus de permiso" class="btn btn-outline-primary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>                </a>
            ';
        }
        //Solo se puede eliminar SI tiene el permiso y SI es el dueño del permiso Y si no ha sido aprobado/denegado
        if ((auth()->user()->hasPermissions("permits.destroy") && auth()->id() == $row->user_id) && (in_array($row->permit_status_name, ["Creado", "Enviado", "En revisión"]))) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
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
                        'responsive' => true,
                        'scrollX' => true,
                    ])
                    ->setTableId('permits-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'asc')
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
            Column::make('permit_user_name')
            ->title('Solicitante')
            ->searchable(true)
            ->orderable(true),
            Column::make('departament_id')
            ->title('Departamento'),
            Column::make('motive_id')
            ->title('Motivo'),
            Column::make('permit_date')
            ->searchable(false)
            ->title('Fecha de solicitud')
            ->addClass('text-center'),
            Column::make('permit_status_name')
            ->title("Status")
            ->addClass('text-center'),
        ];

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

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Permits_' . date('YmdHis');
    }
}
