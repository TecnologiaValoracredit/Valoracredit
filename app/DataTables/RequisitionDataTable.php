<?php

namespace App\DataTables;

use App\Models\Requisition;
use App\Models\RequisitionRow;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RequisitionDataTable extends DataTable
{

    public function __construct(Requisition $requisition)
	{
		$this->requisition = $requisition;
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
        ->setRowId('id')

        // Fechas en formato bonito
        ->editColumn('created_at', function(Requisition $role) {
            return date("d/m/Y H:i", strtotime($role->created_at));
        })
        ->editColumn('updated_at', function(Requisition $role) {
            return date("d/m/Y H:i", strtotime($role->updated_at));
        })
        ->editColumn('request_date', function(Requisition $role) {
            return date("d/m/Y", strtotime($role->request_date));
        })

        // Total con $
        ->editColumn('amount', function(Requisition $role) {
            return '$' . number_format($role->amount, 2);
        })

        // Estatus con colores (ejemplo básico)
        ->editColumn('status_name', function(Requisition $role) {
            switch (strtolower($role->status_name)) {
                case 'autorizado':
                    return '<span class="badge badge-success">'.$role->status_name.'</span>';
                case 'creado':
                    return '<span class="badge badge-warning">'.$role->status_name.'</span>';
                case 'rechazado':
                    return '<span class="badge badge-danger">'.$role->status_name.'</span>';
                default:
                    return '<span class="badge badge-secondary">'.$role->status_name.'</span>';
            }
        });

    $datatable->addColumn('action', function($row){
        return $this->getActions($row);
    })
    ->rawColumns(["action", "is_active", "status_name"]); // 👈 importante habilitar html en status_name

    return $datatable;
}

    public function getActions($row){
    $result = null;
    $isCreator = ($row->user_id == auth()->id());
    $isNotChecked = strtolower($row->status_name) == "creado";

    if ($isCreator && $isNotChecked && auth()->user()->hasPermissions("requisitions.edit")) {
        $result .= '
            <a title="Editar" href='.route("requisitions.edit", $row->id).' class="btn btn-outline-secondary btn-icon p-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                </svg>
            </a>
        ';
    }

    if ($isCreator && $isNotChecked && auth()->user()->hasPermissions("requisitions.destroy")) {
        $result .= '
            <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon p-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
            </a>
        ';
    }

    if (((!$isNotChecked && $isCreator) || auth()->user()->role_id == 3) && auth()->user()->hasPermissions("requisitions.show")) {
        $result .= '
            <a href="' . route('requisitions.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon p-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                    <circle cx="12" cy="12" r="1"/>
                    <circle cx="18" cy="12" r="1"/>
                    <circle cx="24" cy="12" r="1"/>
                </svg>
            </a>
        ';
    }

    if (true) {
        $result .= '
            <a href="' . route('requisitions.exportReport', $row->id) . '" class="btn btn-outline-success btn-icon p-auto">
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
     * @param \App\Models\Requisition $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Requisition $model): QueryBuilder
{
        $query = $model
            ->select([
                'requisitions.*',
                'requisitions.user_id',
                'users.name as user_name',  // Cambiar esto por 'users.name' para mostrar el nombre
                'requisition_statuses.name as status_name'
            ])
            ->leftJoin('users', 'users.id', '=', 'requisitions.user_id')  // Asegúrate de usar el campo correcto
            ->leftJoin('requisition_statuses', 'requisition_statuses.id', '=', 'requisitions.requisition_status_id')  // Asegúrate de usar el campo correcto
            ->newQuery();


        //Si el rol del usuario no es tesorero
        if(auth()->user()->role_id != 3){
            $query = $query->where('requisitions.user_id', auth()->user()->id);
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
                        "scrollX"=> true,
                    ])
                    ->setTableId('requisitions-table')
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
        //Si es tesorero
        if(auth()->user()->role_id == 3){
                $columns = [
                Column::make('id')->title('Folio'),
                Column::make('user_name')->title('Usuario')->name('users.name'),
                Column::make('request_date')->title('Fecha de pedido'),
                Column::make('status_name')->title('Estatus')->name('requisition_statuses.name'),
                Column::make('amount')->title('Total'),
            ];
        }else{
            $columns = [
                Column::make('id')->title('Folio'),
                Column::make('request_date')->title('Fecha de pedido'),
                Column::make('status_name')->title('Estatus')->name('requisition_statuses.name'),
                Column::make('amount')->title('Total'),
            ];
        }

        

        if (auth()->user()->hasPermissions("requisitions.edit") ||
            auth()->user()->hasPermissions("requisitions.create") ||
            auth()->user()->hasPermissions("requisitions.destroy")) {
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
        return 'Requisition_' . date('YmdHis');
    }
}

