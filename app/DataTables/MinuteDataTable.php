<?php

namespace App\DataTables;

use App\Enums\MinuteStatusEnum;
use App\Models\Minute;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MinuteDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatable = (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('meeting_date', function (Minute $minute) {
                return $minute->meeting_date ? $minute->meeting_date->format('d/m/Y') : '';
            })
            ->addColumn('creator_name', function (Minute $minute) {
                return optional($minute->creator)->name ?? '';
            })
            ->addColumn('participants_count', function (Minute $minute) {
                return $minute->participants()->count();
            })
            ->addColumn('tasks_count', function (Minute $minute) {
                return $minute->tasks()->count();
            })
            ->editColumn('status', function (Minute $minute) {
                $labels = MinuteStatusEnum::labels();
                $label  = $labels[$minute->status] ?? $minute->status;
                $class  = match ($minute->status) {
                    'open'     => 'badge-info',
                    'closed'   => 'badge-success',
                    'canceled' => 'badge-danger',
                    default    => 'badge-secondary',
                };
                return '<span class="badge ' . $class . ' mb-2 me-4">' . $label . '</span>';
            })
            ->editColumn('created_at', function (Minute $minute) {
                return date("d/m/Y H:i", strtotime($minute->created_at));
            })
            ->editColumn('updated_at', function (Minute $minute) {
                return date("d/m/Y H:i", strtotime($minute->updated_at));
            })
            ->editColumn('is_active', function (Minute $minute) {
                if ($minute->is_active) {
                    return '<span class="badge badge-success mb-2 me-4">Sí</span>';
                }
                return '<span class="badge badge-danger mb-2 me-4">No</span>';
            });

        $datatable->addColumn('action', function ($row) {
            return $this->getActions($row);
        })->rawColumns(["action", "is_active", "status"]);

        return $datatable;
    }

    public function getActions($row)
    {
        $result = null;

        if (auth()->user()->hasPermissions("minutes.show")) {
            $result .= '
                <a title="Ver" href=' . route("minutes.show", $row->id) . ' class="btn btn-outline-primary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("minutes.edit")) {
            $result .= '
                <a title="Editar" href=' . route("minutes.edit", $row->id) . ' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("minutes.destroy")) {
            $result .= '
                <a onclick="deleteRow(' . $row->id . ')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </a>
            ';
        }

        return $result;
    }

    public function query(Minute $model): QueryBuilder
    {
        return $model->with('creator')->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters([
                'paging'     => true,
                'searching'  => true,
                'info'       => true,
                'responsive' => true,
                'scrollX'    => true,
            ])
            ->setTableId('minutes-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(2, 'desc')
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
            ]);
    }

    public function getColumns(): array
    {
        $columns = [
            Column::make('id')->title('Id')->searchable(false)->visible(false),
            Column::make('title')->title('Título'),
            Column::make('meeting_date')->title('Fecha reunión'),
            Column::make('creator_name')->title('Creado por')->searchable(false)->orderable(false),
            Column::make('participants_count')->title('Participantes')->searchable(false)->orderable(false),
            Column::make('tasks_count')->title('Tareas')->searchable(false)->orderable(false),
            Column::make('status')->title('Estatus'),
            Column::make('created_at')->searchable(false)->title('Fecha creado'),
            Column::make('is_active')->title("Activo"),
        ];

        $columns = array_merge($columns, [
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
                ->title('Acciones'),
        ]);

        return $columns;
    }

    protected function filename(): string
    {
        return 'Minutes_' . date('YmdHis');
    }
}
