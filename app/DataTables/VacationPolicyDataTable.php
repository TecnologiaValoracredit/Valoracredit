<?php

namespace App\DataTables;

use App\Models\VacationPolicy;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VacationPolicyDataTable extends DataTable
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
        ->editColumn('applicable_month_range', function(VacationPolicy $vacation_policy) {
            return "<span>{$vacation_policy->applicable_month_range} meses</span>";
        })
        ->editColumn('created_at', function(VacationPolicy $vacation_policy) {
            return date("d/m/Y H:i", strtotime($vacation_policy->created_at));
        })
        ->editColumn('updated_at', function(VacationPolicy $vacation_policy) {
            return date("d/m/Y H:i", strtotime($vacation_policy->updated_at));
        })
        ->editColumn('is_active', function(VacationPolicy $vacation_policy) {
            if ($vacation_policy->is_active) {
                return '<span class="badge badge-success mb-2 me-4">Sí</span>';
            }
            return '<span class="badge badge-danger mb-2 me-4">No</span>';
        });


        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "applicable_month_range","is_active"]);

        return $datatable;
    }

    public function getActions($row){
        $result = null;
        
        if (auth()->user()->hasPermissions("vacation_policies.destroy")) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("vacation_policies.edit")) {
            $result .= '
                <a title="Editar" href='.route("vacation_policies.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        return $result;
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\VacationPolicy $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(VacationPolicy $model): QueryBuilder
    {
        return $model->select([
            'id',
            'years_from',
            'years_to',
            'days',
            'advance_days',
            'applicable_month_range',
            'is_active',
            'created_at',
            'updated_at',
        ])
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
                        'scrollX' => true,
                    ])
                    ->setTableId('vacation_policies-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1, 'asc')
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
            Column::make('years_from')->title("De años"),
            Column::make('years_to')->title("A años"),
            Column::make('days')->searchable(true)->title("Días"),
            Column::make('advance_days')->searchable(true)->title("Días en avance"),
            Column::make('applicable_month_range')->searchable(true)->title("Rango aplicable"),
            Column::make('is_active')->title("Activo"),
            Column::make('created_at')->title("Fecha creado"),
            Column::make('updated_at')->title("Fecha editado"),
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
        return 'Vacation_policies_' . date('YmdHis');
    }
}
