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
        ->setRowClass(function ($f_flux) {
            if (auth()->user()->role_id == 3) {
                return $f_flux->f_clasification_id == null ? 'table-warning' : '';
            }else if (auth()->user()->role_id == 2) {
                return $f_flux->f_cob_clasification_id == 1 ? 'table-warning' : '';
            }

        })
        ->editColumn('created_at', function(FFlux $f_flux) {
            return date("d/m/Y H:i", strtotime($f_flux->created_at));
        })
        ->editColumn('updated_at', function(FFlux $f_flux) {
            return date("d/m/Y H:i", strtotime($f_flux->updated_at));
        })
        ->editColumn('accredit_date', function(FFlux $f_flux) {
            return date("d/m/Y", strtotime($f_flux->accredit_date));
        })
        ->editColumn('amount', function(FFlux $f_flux) {
            return '$' . number_format($f_flux->amount, 2, '.', ',');
        })
        ->editColumn('f_status_name', function(FFlux $f_flux) {
            if ($f_flux->f_status_id == 2) {
                return '<span class="badge badge-success">Terminado</span>';
            }
            return '<span class="badge badge-danger">Pendiente</span>';
        })
        ->editColumn('f_cartera_status_name', function(FFlux $f_flux) {
            if ($f_flux->f_cartera_status_id == 2) {
                return '<span class="badge badge-success">'.$f_flux->fCarteraStatus->name ?? "Aplicado".'</span>';
            }
            return '<span class="badge badge-danger">'.$f_flux->fCarteraStatus->name ?? "Pendiente".'</span>';
        })
        ->editColumn('f_expense_type_name', function(FFlux $f_flux) {
            return $f_flux->f_expense_type_id == null ? "N/A" : $f_flux->fExpenseType->name;
        })
        ->addColumn('action', function($row){
            return $this->getActions($row);
        })
        ->rawColumns(['action', 'f_status_name', 'f_cartera_status_name']); 

        $datatable->filter(function($query) {
            if (auth()->user()->hasPermissions("f_fluxes.showIncome") && auth()->user()->hasPermissions("f_fluxes.showExpenses")) {
            }else{
                if (auth()->user()->hasPermissions("f_fluxes.showIncome")) {
                    $query->where('f_fluxes.f_movement_type_id', 1);
                }
                if (auth()->user()->hasPermissions("f_fluxes.showExpenses")) {
                    $query->orWhere('f_fluxes.f_movement_type_id', 2);
                }
            }
            
            if(request('initial_accredit_date') !== null){
                $query->whereDate('f_fluxes.accredit_date', '>=', request('initial_accredit_date'));
            }
            
            if(request('final_accredit_date') !== null){
                $query->whereDate('f_fluxes.accredit_date', '<=', request('final_accredit_date'));
            }
            if(request('f_movement_type') !== null){
                $query->where('f_fluxes.f_movement_type_id', '=', request('f_movement_type'));
            }
            if(request('f_account_id') !== null){
                $query->where('f_fluxes.f_account_id', '=', request('f_account_id'));
            }
            if(request('f_status_id') !== null){
                $query->where('f_fluxes.f_status_id', '=', request('f_status_id'));
            }
            if(request('f_cartera_status_id') !== null){
                $query->where('f_fluxes.f_cartera_status_id', '=', request('f_cartera_status_id'));
            }
            if(request('f_clasification') !== null){
                if(request('f_clasification') == "-1"){
                    $query->where('f_fluxes.f_clasification_id', '=', null);
                }else {
                    $query->where('f_fluxes.f_clasification_id', '=', request('f_clasification'));
                }
            }
            if(request('f_cob_clasification') !== null){
                if(request('f_cob_clasification') == "-1"){
                    $query->where('f_fluxes.f_cob_clasification_id', '=', null);
                }else {
                    $query->where('f_fluxes.f_cob_clasification_id', '=', request('f_cob_clasification'));
                }
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
                <a onclick="changeStatus(' . $row->id . ')" title="Cambiar a terminado" class="btn btn-outline-warning btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>                </a>
            ';
        }

        if (auth()->user()->hasPermissions("f_fluxes.changeCarteraStatus") && $row->f_cartera_status_id == 1) {
            $result .= '
                <a onclick="changeCarteraStatus(' . $row->id . ')" title="Cambiar a aplicado" class="btn btn-outline-primary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>                </a>
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
            'f_accounts.name as f_account_name',
            'f_statuses.name as f_status_name',
            'f_cartera_statuses.name as f_cartera_status_name',
            'f_beneficiaries.name as f_beneficiary_name',
			'f_movement_types.name as f_movement_type_name',
            'f_clasifications.name as f_clasification_name',
            'f_cob_clasifications.name as f_cob_clasification_name',
            'f_expense_types.name as f_expense_type_name',
		)
        ->leftjoin('f_accounts', 'f_fluxes.f_account_id', '=', 'f_accounts.id')
        ->leftjoin('f_statuses', 'f_fluxes.f_status_id', '=', 'f_statuses.id')
        ->leftjoin('f_cartera_statuses', 'f_fluxes.f_cartera_status_id', '=', 'f_cartera_statuses.id')
        ->leftjoin('f_beneficiaries', 'f_fluxes.f_beneficiary_id', '=', 'f_beneficiaries.id')
        ->leftjoin('f_movement_types', 'f_fluxes.f_movement_type_id', '=', 'f_movement_types.id')
        ->leftjoin('f_clasifications', 'f_fluxes.f_clasification_id', '=', 'f_clasifications.id')
        ->leftjoin('f_cob_clasifications', 'f_fluxes.f_cob_clasification_id', '=', 'f_cob_clasifications.id')
        ->leftjoin('f_expense_types', 'f_fluxes.f_expense_type_id', '=', 'f_expense_types.id')
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
                        'responsive' => true, // Habilitar responsividad
                        'scrollX' =>true,
                        'dom' => 'lBfrtip',// IMPORTANTE: Asegura que los botones se rendericen
                        'stateSave' => true, // Guarda el estado de la tabla (incluye ColVis)
                    ])
                    ->setTableId('f_fluxes-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, "asc")
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('colvis')->text('Mostrar/Ocultar Columnas'), // Botón para visibilidad de columnas
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
            ->visible(false),
            Column::make('accredit_date')->title('Fecha acreditado'),
            Column::make('f_account_name')->title('Cuenta')->name("f_accounts.name"),
            Column::make('f_beneficiary_name')->title('Beneficiario')->name("f_beneficiaries.name")->className("text-wrap"),
            Column::make('concept')->title('Concepto')->className("text-wrap"),
            Column::make('f_movement_type_name')->title('Tipo de movimiento')->name("f_movement_types.name"),
            Column::make('f_expense_type_name')->title('Tipo de gasto')->name("f_expense_types.name"),
            Column::make('amount')->title('Cantidad'),
            Column::make('f_clasification_name')->title('Calsificación Admin.')->name("f_clasifications.name")->className("text-wrap"),
            Column::make('f_cob_clasification_name')->title('Clasificación Cartera.')->name("f_cob_clasifications.name")->className("text-wrap"),

            Column::make('notes1')->title('Notas admin.')->className("text-wrap"),
            Column::make('notes2')->title('Notas cartera')->className("text-wrap"),
            
            Column::make('f_status_name')->title('Cont.')->name("f_statuses.name"),
            Column::make('f_cartera_status_name')->title('Cartera')->name("f_statuses.name"),

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
