<?php

namespace App\DataTables;

use App\Models\FixedExpense;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FixedExpenseDataTable extends DataTable
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
        ->editColumn('created_at', function(FixedExpense $fixedExpense) {
            return date("d/m/Y H:i", strtotime($fixedExpense->created_at));
        })
        ->editColumn('updated_at', function(FixedExpense $fixedExpense) {
            return date("d/m/Y H:i", strtotime($fixedExpense->updated_at));
        })
        ->editColumn('is_active', function(FixedExpense $fixedExpense) {
            if ($fixedExpense->is_active) {
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
        
        if (auth()->user()->hasPermissions("fixed_expenses.destroy")) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("fixed_expenses.show")) {
            $result .= '
                <a href="'. route('fixed_expenses.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon ps-2 px-1">
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
     * @param \App\Models\FixedExpense $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FixedExpense $model): QueryBuilder
    {
        return $model->select([
            'fixed_expenses.id',
            'fixed_expenses.name',
            'fixed_expenses.description',
            'fixed_expenses.is_active',
            'fixed_expenses.created_at',
            'fixed_expenses.updated_at',
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
                    ->setTableId('fixedexpenses-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
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
            Column::make('name')->title("Nombre"),
            Column::make('description')->title("Descripción"),
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
        return 'FixedExpense_' . date('YmdHis');
    }
}
