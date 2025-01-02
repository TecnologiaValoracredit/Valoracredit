<?php

namespace App\DataTables;

use App\Models\ChkChecklist;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ChkChecklistDataTable extends DataTable
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
            ->editColumn('created_at', function (ChkChecklist $chk_checklist) {
                return date("d/m/Y H:i", strtotime($chk_checklist->created_at));
            })
            ->editColumn('updated_at', function (ChkChecklist $chk_checklist) {
                return date("d/m/Y H:i", strtotime($chk_checklist->updated_at));
            })
            ->editColumn('date', function (ChkChecklist $chk_checklist) {
                return date("d/m/Y", strtotime($chk_checklist->date));
            })
            ->editColumn('is_active', function (ChkChecklist $chk_checklist) {
                return $chk_checklist->is_active
                    ? '<span class="badge badge-success mb-2 me-4">Sí</span>'
                    : '<span class="badge badge-danger mb-2 me-4">No</span>';
            });

        // Agregar columna de acciones
        $datatable->addColumn('action', function ($row) {
            return $this->getActions($row);
        })->rawColumns(["action", "is_active"]);

        return $datatable;
    }

    public function getActions($row)
    {
        $result = '';
        if (auth()->user()->hasPermissions("chk_checklists.edit")) {
            $result .= '
                <a title="Editar" href=' . route("chk_checklists.edit", $row->id) . ' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("chk_checklists.destroy")) {
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
     * @param \App\Models\ChkChecklist $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ChkChecklist $model): QueryBuilder
    {
        $query = ChkChecklist::select(
            'chk_checklists.id',
            'chk_checklists.client_name',
            'chk_checklists.date',
            'chk_checklists.rfc',
            'chk_checklists.credit_ammount',
            'chk_checklists.dispersed_ammount',
            'chk_checklists.chk_credit_type_id',
            'chk_checklists.exp_type_id',
            'chk_checklists.institution_id',
            'institutions.name as institution_name',
            'chk_credit_types.name as chk_credit_type_name',
            'exp_types.name as exp_type_name',
            'chk_checklists.created_at',
            'chk_checklists.updated_at',
            'chk_checklists.is_active'
        )
        ->leftJoin('institutions', 'chk_checklists.institution_id', '=', 'institutions.id')
        ->leftJoin('chk_credit_types', 'chk_checklists.chk_credit_type_id', '=', 'chk_credit_types.id')
        ->leftJoin('exp_types', 'chk_checklists.exp_type_id', '=', 'exp_types.id');

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
                        'responsive' => true,  // Habilitar responsividad
                    ])
                    ->setTableId('chk_checklists-table')
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
                
            Column::make('client_name')
                ->title('Nombre')
                ->searchable(true)
                ->orderable(true)
                ->printable(true),
            Column::make('date')
                ->title('Fecha')
                ->searchable(true)
                ->orderable(true)
                ->printable(true),
            Column::make('rfc')
                ->title('RFC')
                ->searchable(true)
                ->orderable(true)
                ->printable(true),
            Column::make('institution_name')
                ->title('Institución')
                ->searchable(true)
                ->orderable(true)
                ->printable(true),
            Column::make('chk_credit_type_name')
                ->title('Tipo de Crédito')
                ->searchable(true)
                ->orderable(true)
                ->printable(true),
            Column::make('exp_type_name')
                ->title('Tipo de Firma')
                ->searchable(true)
                ->orderable(true)
                ->printable(true),
            Column::make('credit_ammount')
                ->title('Monto del crédito')
                ->searchable(true)
                ->orderable(true)
                ->printable(true),
            Column::make('dispersed_ammount')
                ->title('Monto dispersado')
                ->searchable(true)
                ->orderable(true)
                ->printable(true),
            Column::make('created_at')
                ->title('Fecha Creado')
                ->searchable(false)
                ->orderable(false),
            Column::make('updated_at')
                ->title('Fecha Editado')
                ->searchable(false)
                ->orderable(false),
            Column::make('is_active')
                ->title('Activo')
                ->searchable(false)
                ->orderable(false),
        ];

        if (auth()->user()->hasPermissions("chk_checklists.edit") ||
            auth()->user()->hasPermissions("chk_checklists.create") ||
            auth()->user()->hasPermissions("chk_checklists.destroy")) {
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
        return 'ChkChecklist' . date('YmdHis');
    }
}
