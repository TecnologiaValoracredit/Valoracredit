<?php

namespace App\DataTables;

use App\Enums\VacationStatusEnum;
use App\Models\Vacation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VacationDataTable extends DataTable
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
        ->editColumn('status_name', function(Vacation $vacation) {
            return '<span class="badge '. $vacation->badge . ' text-light">' . 
            $vacation->status_name . '</span>';
        })
        ->editColumn('created_at', function(Vacation $vacation) {
            return date("d/m/Y H:i", strtotime($vacation->created_at));
        })
        ->editColumn('is_active', function(Vacation $vacation) {
            if ($vacation->is_active) {
                return '<span class="badge badge-success mb-2 me-4">Sí</span>';
            }
            return '<span class="badge badge-danger mb-2 me-4">No</span>';
        });

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "status_name", "is_active"]);

        return $datatable;
    }

    public function getActions($row){
        $result = null;

        $destroyChecks = $row->user_id == auth()->id() && $row->status_name ==  VacationStatusEnum::CREATED->value;
        $editChecks = $row->user_id == auth()->id() && $row->status_name ==  VacationStatusEnum::CREATED->value;
        $changeStatusChecks = ($row->boss_id == auth()->id() && $row->status_name ==  VacationStatusEnum::PENDING_BOSS->value) 
            || (auth()->user()->hasPermissions('vacations.seeAllVacations') && $row->status_name ==  VacationStatusEnum::PENDING_HR->value);
        $exportChecks = $row->status_name ==  VacationStatusEnum::APPROVED->value;
        
        //SHOW
        $result .= '
            <a href="'. route('vacations.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon p-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                    <circle cx="12" cy="12" r="1"/>
                    <circle cx="18" cy="12" r="1"/>
                    <circle cx="24" cy="12" r="1"/>
                </svg>
            </a>
        ';

        //EDITAR
        if (auth()->user()->hasPermissions("vacations.edit") && $editChecks) {
            $result .= '
                <a title="Editar" href='.route("vacations.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }

        //CAMBIAR ESTATUS
        if (auth()->user()->hasPermissions('vacations.changeStatus') && $changeStatusChecks) {
            $result .= '
                <a href="'.route('vacations.changeStatus', $row->id).'" title="Cambiar estatus de requisición" class="btn btn-outline-primary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="10" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>                </a>
            ';
        }

        //DESTRUIR
        if (auth()->user()->hasPermissions("vacations.destroy") && $destroyChecks) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                </a>
            ';
        }

        if (auth()->user()->hasPermissions('vacations.exportPdf') && $exportChecks){
            $result .= '
                <a href="' . route('vacations.exportPdf', $row->id) . '" target="_blank" class="btn btn-outline-success btn-icon p-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 576 512" fill="currentColor">
                        <path d="M208 48L96 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16l80 0 0 48-80 0c-35.3 0-64-28.7-64-64L32 64C32 28.7 60.7 0 96 0L229.5 0c17 0 33.3 6.7 45.3 18.7L397.3 141.3c12 12 18.7 28.3 18.7 45.3l0 149.5-48 0 0-128-88 0c-39.8 0-72-32.2-72-72l0-88zM348.1 160L256 67.9 256 136c0 13.3 10.7 24 24 24l68.1 0zM240 380l32 0c33.1 0 60 26.9 60 60s-26.9 60-60 60l-12 0 0 28c0 11-9 20-20 20s-20-9-20-20l0-128c0-11 9-20 20-20zm32 80c11 0 20-9 20-20s-9-20-20-20l-12 0 0 40 12 0zm96-80l32 0c28.7 0 52 23.3 52 52l0 64c0 28.7-23.3 52-52 52l-32 0c-11 0-20-9-20-20l0-128c0-11 9-20 20-20zm32 128c6.6 0 12-5.4 12-12l0-64c0-6.6-5.4-12-12-12l-12 0 0 88 12 0zm76-108c0-11 9-20 20-20l48 0c11 0 20 9 20 20s-9 20-20 20l-28 0 0 24 28 0c11 0 20 9 20 20s-9 20-20 20l-28 0 0 44c0 11-9 20-20 20s-20-9-20-20l0-128z"/>
                    </svg>
                </a>
            ';
        }

        return $result;
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Vacation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Vacation $model): QueryBuilder
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query =  $model
        ->select([
            'vacations.id',
            'vacations.user_id',
            'vacations.boss_id',
            'users.name as user_name',
            'vacations.total_days',
            'vacation_statuses.name as status_name',
            'vacation_statuses.badge',
            'vacations.reason',
            'vacations.is_active',
            'vacations.created_at',
        ])
        ->join('users', 'users.id', '=', 'vacations.user_id')
        ->join('vacation_statuses', 'vacation_statuses.id', '=', 'vacations.vacation_status_id')
        ->where('vacations.is_active', true);

        $user = auth()->user();

        //Si el usuario no cuenta con permiso para ver todas las vacaciones
        if (!$user->hasPermissions('vacations.seeAllVacations')) {
            $query->where(function($q) use ($user) {
                $q->where('vacations.user_id', $user->id)
                ->orWhere('vacations.boss_id', $user->id);
            });
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
                        'scrollX' => true,
                    ])
                    ->setTableId('vacations-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
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
            Column::make('user_name')->title("Usuario")->searchable(true),
            Column::make('total_days')->title("Días totales"),
            Column::make('reason')->title("Razón"),
            Column::make('created_at')->title("Fecha creado"),
            Column::make('status_name')->title("Estatus")->searchable(true),
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
        return 'Vacations_' . date('YmdHis');
    }
}
