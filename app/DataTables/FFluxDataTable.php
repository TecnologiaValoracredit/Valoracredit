<?php

namespace App\DataTables;

use App\Models\FFlux;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FFluxDataTable extends DataTable
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
        ->editColumn('created_at', function(FFlux $f_flux) {
            return date("d/m/Y H:i", strtotime($f_flux->created_at));
        })
        ->editColumn('updated_at', function(FFlux $f_flux) {
            return date("d/m/Y H:i", strtotime($f_flux->updated_at));
        })
        ->editColumn('accredit_date', function(FFlux $f_flux) {
            return date("d/m/Y", strtotime($f_flux->accredit_date));
        })

        ->editColumn('f_status_name', function(FFlux $f_flux) {
            if ($f_flux->f_status_id == 2) {
                return '<span class="badge badge-success mb-2 me-4">Terminado</span>';
            }
            return '<span class="badge badge-danger mb-2 me-4">Pendiente</span>';
        })
        ->rawColumns(['f_status_name'])  
        ->addColumn('action', function($row){
            return $this->getActions($row);
        })
        ->rawColumns(['action', 'f_status_name']); 

        $datatable->filter(function($query) {

            if(request('initial_accredit_date') !== null){
                $query->whereDate('f_fluxes.accredit_date', '>=', request('initial_accredit_date'));
            }
        
            if(request('final_accredit_date') !== null){
                $query->whereDate('f_fluxes.accredit_date', '<=', request('final_accredit_date'));
            }
        
            if(request('f_movement_type') !== null){
                $query->where('f_fluxes.f_movement_type_id', '=', request('f_movement_type'));
            }
        
            if(request('f_status_id') !== null){
                $query->where('f_fluxes.f_status_id', '=', request('f_status_id'));
            }
            
            if(request('f_beneficiary_id') !== null){
                $query->where('f_fluxes.f_beneficiary_id', '=', request('f_beneficiary_id'));
            }

            if (auth()->user()->hasPermissions("f_fluxes.showIncome")) {
                $query->where('f_movement_type_id', 1);
            }
            
            if (auth()->user()->hasPermissions("f_fluxes.showExpenses")) {
                $query->orWhere('f_movement_type_id', 2);
            }
        
           
		}, true);
    

        return $datatable;
    }

    public function getActions($row){
        
        $result = null;
        if (auth()->user()->hasPermissions("f_fluxes.edit")) {
            $result .= '
                <a title="Editar" href='.route("f_fluxes.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
      
        if (auth()->user()->hasPermissions("f_fluxes.changeStats") && $row->f_status_id == 1) {
            $result .= '
                <a onclick="changeStatus(' . $row->id . ')" title="Estado" class="btn btn-outline-warning btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-toggle-left"/></svg>
                </a>
            ';
        }
        return $result;
	}

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FFlux $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FFlux $model): QueryBuilder
    {
        return $model->select(
			'f_fluxes.*',
            'f_statuses.name as f_status_name',
            'f_beneficiaries.name as f_beneficiary_name',
			'f_movement_types.name as f_movement_type_name',
		)
        ->leftjoin('f_statuses', 'f_fluxes.f_status_id', '=', 'f_statuses.id')
        ->leftjoin('f_beneficiaries', 'f_fluxes.f_beneficiary_id', '=', 'f_beneficiaries.id')
        ->leftjoin('f_movement_types', 'f_fluxes.f_movement_type_id', '=', 'f_movement_types.id')
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
                    ])
                    ->setTableId('f_fluxes-table')
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
            Column::make('accredit_date')->title('Fecha acreditado'),
            Column::make('f_beneficiary_name')->title('Beneficiario')->name("f_beneficiaries.name")->searchable(true),
            Column::make('concept')->title('Concepto'),
            Column::make('f_movement_type_name')->title('Tipo de movimiento')->name("f_movement_types.name")->searchable(true),
            Column::make('amount')->title('Cantidad'),
            Column::make('notes1')->title('Notas admin.'),
            Column::make('notes2')->title('Notas cartera'),
            
            Column::make('f_status_name')->title('Estatus')->name("f_statuses.name")->searchable(true),

        ];

        if (auth()->user()->hasPermissions("f_fluxes.edit") ||
            auth()->user()->hasPermissions("f_fluxes.create") ||
            auth()->user()->hasPermissions("f_fluxes.changeStats")) {
               
               
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
        return 'FFlux_' . date('YmdHis');
    }
}
