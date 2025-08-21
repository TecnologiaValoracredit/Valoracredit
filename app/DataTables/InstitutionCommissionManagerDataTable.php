<?php

namespace App\DataTables;

use App\Models\InstitutionCommissionManager;
use App\Models\SManager;
use App\Models\User;
use App\Models\SCoordinator;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InstitutionCommissionManagerDataTable extends DataTable
{

    public function __construct(SManager $manager)
	{
		$this->manager = $manager;
	}
    
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatable = (new EloquentDataTable($query))
        ->setRowId('id');

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action"]);

        return $datatable;
    }

    public function getActions($row){
        $result = null;
        if (auth()->user()->hasPermissions("commissions.destroy")) {
            $result .= '
                <a onclick="deleteInstitutionFromManager('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                </a>
            ';
        }
        return $result;
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\InstitutionCommission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(InstitutionCommissionManager $model): QueryBuilder
    {
        return $model->select(
            "institution_commission_managers.*",
            "institutions.id as institution_id",
            "institutions.name as institution_name",
        )
        ->where("manager_id", $this->manager->id)
        ->leftjoin('institutions', 'institution_commission_managers.institution_id', '=', 'institutions.id')
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
                    ->setTableId('institution_commission_managers-table')
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
            ->visible(false)->name("institution_commission_managers.id"),
            Column::make('institution_name')->title('Institución')->name("institutions.name"),
            Column::make('percentage')->title('Porcentaje'),

        ];

        if (auth()->user()->hasPermissions("commissions.edit") ||
            auth()->user()->hasPermissions("commissions.create") ||
            auth()->user()->hasPermissions("commissions.destroy")) {
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
        return 'InstitutionCommissionManagers_' . date('YmdHis');
    }
}
