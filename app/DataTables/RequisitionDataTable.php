<?php

namespace App\DataTables;

use App\Enums\RequisitionOwnerPermissionEnum;
use App\Enums\RequisitionStatusEnum;
use App\Models\RequisitionStatus;
use App\Models\Requisition;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
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
            return '<span class="badge '. $role->status_color . ' text-light">' . 
            $role->status_name . '</span>';
        });

    $datatable->addColumn('action', function($row){
        return $this->getActions($row);
    })
    ->rawColumns(["action", "is_active", "status_name"]); // 👈 importante habilitar html en status_name

    return $datatable;
}

    public function getActions($row){
    $result = null;
    $status = $row->status_name;

    $isCreator = $row->request_id == auth()->id();
    $isCreatorChecks = ($status == RequisitionStatusEnum::CREATED->value || $status == RequisitionStatusEnum::RETURNED_BY_BOSS->value);

    $isBoss = $row->boss_id == auth()->id();;
    $isBossChecks = $status == RequisitionStatusEnum::SENT_TO_BOSS->value || $status == RequisitionStatusEnum::RETURNED_BY_TREASURY->value;

    $hasCurrentPermission = $row->current_owner_permission == RequisitionOwnerPermissionEnum::BOSS->value && $isBoss || 
                            auth()->user()->hasPermissions($row->current_owner_permission) && 
                            $row->current_owner_permission != RequisitionOwnerPermissionEnum::BOSS->value;
    
    //Permite cambiar estatus si no se encuentra en ninguno de los siguientes
    $changeStatusCheck = ($status != RequisitionStatusEnum::STAND_BY_TREASURY->value && 
                            $status != RequisitionStatusEnum::GLOBAL_REVIEW->value &&
                            $status != RequisitionStatusEnum::READY_FOR_DG->value &&
                            $status != RequisitionStatusEnum::RETURNED_BY_DG->value);


    if (auth()->user()->hasPermissions("requisitions.edit") && (($isCreator && $isCreatorChecks) || ($isBoss && $isBossChecks))) {
        $result .= '
            <a title="Editar" href='.route("requisitions.edit", $row->id).' class="btn btn-outline-secondary btn-icon p-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                </svg>
            </a>
        ';
    }

    if (auth()->user()->hasPermissions("requisitions.destroy") && (($isCreator && $status == RequisitionStatusEnum::CREATED->value))) {
        $result .= '
            <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon p-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
            </a>
        ';
    }

    if ($hasCurrentPermission && $changeStatusCheck){
        $result .= '
            <a href="'.route('requisitions.changeStatus', $row->id).'" title="Cambiar estatus de requisición" class="btn btn-outline-primary btn-icon ps-2 px-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="10" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>                </a>
        ';
    }

    $result .= '
        <a href="'. route('requisitions.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon p-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                <circle cx="12" cy="12" r="1"/>
                <circle cx="18" cy="12" r="1"/>
                <circle cx="24" cy="12" r="1"/>
            </svg>
        </a>
    ';
    
    //SUBIR COMPROBANTE DE PAGO
    if ($status == RequisitionStatusEnum::AUTHORIZED_BY_DG->value){
        $result .= '
            <a href="'. route('requisitions.payment', $row->id) . '" title="Subir pago" class="btn btn-outline-success btn-icon p-auto">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z"/>
                </svg>
            </a>
        ';
    }

    //EXPORTAR A PDF EL DOCUMENTO
    if ($status != RequisitionStatusEnum::CREATED->value){
        $result .= '
            <a href="' . route('requisitions.exportPdf', $row->id) . '" target="_blank" class="btn btn-outline-success btn-icon p-auto">
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
        $latestLogSub = DB::table('requisition_logs')
            ->select('requisition_id', DB::raw('MAX(id) as last_log_id'))
            ->groupBy('requisition_id');

        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = $model
            ->select([
                'requisitions.id',
                'requisitions.folio',
                'requisitions.request_id',
                'requisitions.boss_id',
                'requisitions.is_active',
                'requisitions.request_date',
                'requisitions.amount',
                'requisitions.current_owner_permission',
                'users.name as user_name',
                'requisition_statuses.name as status_name',
                'requisition_statuses.color as status_color',
                'suppliers.name as supplier_name',
                'expense_types.name as expense_type_name',
            ])
            ->leftJoin('suppliers', 'suppliers.id', '=', 'requisitions.supplier_id')
            ->leftJoin('expense_types', 'expense_types.id', '=', 'requisitions.expense_type_id')
            ->leftJoin('users', 'users.id', '=', 'requisitions.request_id')
            ->leftJoinSub($latestLogSub, 'latest_log', function ($join) {
                $join->on('latest_log.requisition_id', '=', 'requisitions.id');
            })
            ->leftJoin(
                'requisition_logs',
                'requisition_logs.id',
                '=',
                'latest_log.last_log_id'
            )
            ->leftJoin(
                'requisition_statuses',
                'requisition_statuses.id',
                '=',
                'requisition_logs.to_status_id'
            )
            ->where('requisitions.is_active', 1);

        $accountantRole = Role::where('name', 'Contabilidad')->first();
        $currentRoleName = auth()->user()->role->name;

        if ($currentRoleName == $accountantRole->name){
            //Si es contabilidad, solo trae las requisiciones que necesitan su accion o las suyas
            $query = $query->where(function($q) {
                $q->where('requisitions.current_owner_permission', RequisitionOwnerPermissionEnum::ACCOUNTING->value)
                ->orWhere('requisitions.request_id', auth()->id());
            });
        }
        else if (!auth()->user()->hasPermissions('requisitions.seeAllRequisitions')){
            //Si no es tesoreria, que muestre al aplicante sus propias requisiciones
            $query = $query->where(function($q) {
                $q->where('requisitions.request_id', auth()->id())

                //O si es jefe de alguien, que muestre la requisicion si no se ha mandado
                ->orWhere(function ($q2){
                    $createdStatus = RequisitionStatus::where('name', 'Creada')->first();

                    $q2->Where('requisitions.boss_id', auth()->id())
                    ->whereNot('requisition_logs.to_status_id', $createdStatus->id);
                });
            });
        }
        //En caso de ser tesoreria o tener el permiso
        else if(auth()->user()->hasPermissions('requisitions.seeAllRequisitions')){
            $query = $query->where(function ($q) {
                $createdStatus = RequisitionStatus::where('name', 'Creada')->first();

                $q->whereNot('requisition_logs.to_status_id', $createdStatus->id)
                ->orWhere(function ($q1) {
                    $q1->where('requisitions.request_id', auth()->id());
                })
                ->orWhere(function ($q2) {
                    $createdStatus = RequisitionStatus::where('name', 'Creada')->first();

                    $q2->where('requisitions.boss_id', auth()->id())
                        ->whereNot('requisition_logs.to_status_id', $createdStatus->id);
                });
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
                        "scrollX"=> true,
                    ])
                    ->setTableId('requisitions-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, "desc")
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
        if(auth()->user()->hasPermissions('requisitions.seeAllRequisitions')){
            $columns = [
                Column::make('user_name')->title('Usuario')->name('users.name')->searchable(true),
                Column::make('folio')->title('Folio'),
                Column::make('supplier_name')->title('Proveedor')->name('suppliers.name')->searchable(true),
                Column::make('expense_type_name')->title('Tipo de Gasto')->name('expense_types.name')->searchable(true),
                Column::make('request_date')->title('Fecha de pedido')->searchable(false),
                Column::make('status_name')->title('Estatus')->name('requisition_statuses.name')->searchable(true),
                Column::make('amount')->title('Total')->searchable(true),
            ];
        }else{
            $columns = [
                Column::make('folio')->title('Folio'),
                Column::make('supplier_name')->title('Proveedor')->name('suppliers.name')->searchable(true),
                Column::make('expense_type_name')->title('Tipo de Gasto')->name('expense_types.name')->searchable(true),
                Column::make('request_date')->title('Fecha de pedido')->searchable(false),
                Column::make('status_name')->title('Estatus')->name('requisition_statuses.name')->searchable(true),
                Column::make('amount')->title('Total')->searchable(true),
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

