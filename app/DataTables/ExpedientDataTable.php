<?php

namespace App\DataTables;

use App\Models\Expedient;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ExpedientDataTable extends DataTable
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
        ->editColumn('created_at', function(Expedient $expedient) {
            return date("d/m/Y H:i", strtotime($expedient->created_at));
        })
        ->editColumn('updated_at', function(Expedient $expedient) {
            return date("d/m/Y H:i", strtotime($expedient->updated_at));
        })
        ->editColumn('ubi_status_name', function(Expedient $expedient) {
            if ($expedient->ubi_status_name == "PENDIENTE") {
                if (auth()->user()->hasPermissions("expedients.update")) {
                    return '
                        <span class="badge badge-danger me-1">'.$expedient->ubi_status_name.'</span>
                        <a title="Resguardar" onclick="findExpedient('.$expedient->id.', '.$expedient->credit_id.')" class="btn m-0 px-2">✓</a>
                    ';
                }
            }
            if ($expedient->ubi_status_name == "RESGUARDADO") {
                return '<span class="badge badge-success me-1">'.$expedient->ubi_status_name.'</span>';
            }
            if ($expedient->ubi_status_name == "NO APLICA") {
                return '<span class="badge badge-dark me-1">'.$expedient->ubi_status_name.'</span>';
            }
            if ($expedient->ubi_status_name == "SAFE DATA") {
                return '<span class="badge badge-primary me-1">'.$expedient->ubi_status_name.'</span>';
            }
        });


        $datatable->rawColumns(["action", "ubi_status_name"]);

        return $datatable;
    }

    public function getActions($row){
        $result = null;
        if (auth()->user()->hasPermissions("expedients.update")) {
            $result .= '
                <a title="Editar" href='.route("expedients.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("expedients.show")) {
            $result .= '
                <a title="Permisos" href='.route("expedients.show", $row->id).' class="btn btn-outline-dark btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>        
                </a>
            ';
        }

        return $result;
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Expedient $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Expedient $model): QueryBuilder
    {
        return $model->select(
			'expedients.*',
            'ubi_statuses.name as ubi_status_name',
			'institutions.name as institution_name',
            'anchorers.name as anchorer_name',
            'exp_statuses.name as exp_status_name',
            'exp_types.name as exp_type_name',
            'ubications.name as ubication_name',
		)
        ->leftjoin('institutions', 'expedients.institution_id', '=', 'institutions.id')
        ->leftjoin('anchorers', 'expedients.anchorer_id', '=', 'anchorers.id')
        ->leftjoin('exp_statuses', 'expedients.exp_status_id', '=', 'exp_statuses.id')
        ->leftjoin('ubi_statuses', 'expedients.ubi_status_id', '=', 'ubi_statuses.id')
        ->leftjoin('ubications', 'expedients.ubication_id', '=', 'ubications.id')
        ->leftjoin('exp_types', 'expedients.exp_type_id', '=', 'exp_types.id')
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
                    ->setTableId('expedients-table')
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
            Column::make('credit_id')->title('#Credito'),
            Column::make('ubi_status_name')->title('Estatus')->name("ubi_statuses.name"),
            Column::make('client_name')->title('Cliente'),
            Column::make('opening_date')->title('Apertura'),
            Column::make('exp_type_name')->title('Tipo')->name("exp_types.name"),
            Column::make('institution_name')->title('Institución')->name("institutions.name"),
            Column::make('anchorer_name')->title('Fondeador')->name("anchorers.name"),
            Column::make('exp_status_name')->title('Estado')->name("exp_statuses.name"),
            Column::make('ubication_name')->title('Ubicación')->name("ubications.name"),

            Column::make('created_at')->visible(false)->searchable(false)->title('Fecha creado'),
            Column::make('updated_at')->visible(false)->searchable(false)->title('Fecha editado'),

        ];

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Expedients_' . date('YmdHis');
    }
}
