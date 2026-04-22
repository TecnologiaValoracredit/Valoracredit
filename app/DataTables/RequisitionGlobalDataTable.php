<?php

namespace App\DataTables;

use App\Enums\RequisitionGlobalStatusEnum;
use App\Models\RequisitionGlobal;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RequisitionGlobalDataTable extends DataTable
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
        ->editColumn('id', function ($row) {
            return "<span>RG-{$row->id}</span>";
        })
        ->editColumn('status_name', function($row) {
            return '<span class="badge '. $row->badge . '">' . 
            $row->status_name . '</span>';
        })
        ->editColumn('created_at', function($row) {
            return date("d/m/Y H:i", strtotime($row->created_at));
        })
        ->editColumn('suppliers', function($row) {
            return str_replace(',', "</br>", $row->suppliers);
        })
        ->editColumn('total_amount', function($row) {
            return '$' . number_format($row->total_amount, 2);
        });

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "status_name", "id", "suppliers"]);

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RequisitionGlobal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
public function query(RequisitionGlobal $model): QueryBuilder
{
    /** @var \Illuminate\Database\Eloquent\Builder $query */
    $query = $model
        ->select(
            'requisition_globals.id',
            'requisition_globals.created_at',
            'requisition_globals.updated_at',
            'requisition_global_statuses.name as status_name',
            'requisition_global_statuses.badge',
            DB::raw('GROUP_CONCAT(DISTINCT suppliers.name) as suppliers'),
            DB::raw('SUM(requisitions.amount) as total_amount')
        )
        ->leftJoin('requisition_global_statuses', 'requisition_globals.requisition_global_status_id', '=', 'requisition_global_statuses.id')
        ->leftJoin('requisitions', 'requisitions.requisition_global_id', '=', 'requisition_globals.id')
        ->leftJoin('suppliers', 'suppliers.id', '=', 'requisitions.supplier_id')
        ->where('requisition_globals.is_active', true)
        ->groupBy(
            'requisition_globals.id',
            'requisition_globals.created_at',
            'requisition_globals.updated_at',
            'requisition_global_statuses.name',
            'requisition_global_statuses.badge'
        );

        $dgRole = Role::where('name', 'Dirección general')->first();
        $sentToDgEnum = RequisitionGlobalStatusEnum::SENT_TO_DG;
        $finalizedEnum = RequisitionGlobalStatusEnum::FINALIZED;

        //Si es DG, solamente enseña las globales que han sido enviadas o finalizadas
        if (auth()->user()->role->name == $dgRole->name){
            $query = $query->where('status_name', $sentToDgEnum->value)
                ->orWhere('status_name', $finalizedEnum->value);
        }

        return $query;
}

    public function getActions($row){
        $result = null;

        $currentRoleName = auth()->user()->role->name;
   
        $editChecks = $row->status_name == RequisitionGlobalStatusEnum::CREATED->value || $row->status_name == RequisitionGlobalStatusEnum::REVIEWED->value; //VERIFICA QUE LA GLOBAL ESTE EN CREADA

        $destroyChecks = $row->status_name == RequisitionGlobalStatusEnum::CREATED->value;

        $changeStatusChecks = ($row->status_name == RequisitionGlobalStatusEnum::SENT_TO_ADMIN_AND_ACCOUNT->value || $row->status_name == RequisitionGlobalStatusEnum::UNDER_REVIEW->value) //VERIFICA QUE YA SE HAYA MANDADO LA GLOBAL
        && $this->verifyRoleHasNotReviewed($row->id, $currentRoleName); //VERIFICA QUE EL ROL ACTUAL NO HAYA YA CHECADO LA GLOBAL

        //QUE SOLO PUEDA ENTRAR EL QUE TENGA LOS PERMISOS Y [OPCIONAL QUE SOLO SEA DIRECCIÓN GENERAL]
        $reviewChecks = $row->status_name == RequisitionGlobalStatusEnum::SENT_TO_DG->value;

        $exportChecks = $row->status_name != RequisitionGlobalStatusEnum::CREATED->value;

        if (auth()->user()->hasPermissions("requisition_globals.edit") && $editChecks){
            $result .= '
                <a title="Editar" href='.route("requisition_globals.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("requisition_globals.destroy") && $destroyChecks){
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("requisition_globals.show")){
            $result .= '
                <a href="'. route('requisition_globals.show', $row->id) . '" title="Ver Más" class="btn btn-outline-info btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                        <circle cx="12" cy="12" r="1"/>
                        <circle cx="18" cy="12" r="1"/>
                        <circle cx="24" cy="12" r="1"/>
                    </svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("requisition_globals.changeStatus") && $changeStatusChecks){
            $result .= '
                <a href="'.route('requisition_globals.changeStatus', $row->id).'" title="Cambiar estatus de requisición" class="btn btn-outline-primary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="10" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>                </a>
            ';
        }
        if (auth()->user()->hasPermissions("requisition_globals.review") && $reviewChecks){
            $result .= '
                <a href="'.route('requisition_globals.review', $row->id).'" title="Cambiar estatus de requisición" class="btn btn-outline-dark btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a10 10 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733q.086.18.138.363c.077.27.113.567.113.856s-.036.586-.113.856c-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.2 3.2 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.8 4.8 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                    </svg>
                </a>
            ';
        }

        if ($exportChecks){
            $result .= '
                <a href="' . route('requisition_globals.exportPdf', $row->id) . '" target="_blank" class="btn btn-outline-success btn-icon p-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 576 512" fill="currentColor">
                        <path d="M208 48L96 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16l80 0 0 48-80 0c-35.3 0-64-28.7-64-64L32 64C32 28.7 60.7 0 96 0L229.5 0c17 0 33.3 6.7 45.3 18.7L397.3 141.3c12 12 18.7 28.3 18.7 45.3l0 149.5-48 0 0-128-88 0c-39.8 0-72-32.2-72-72l0-88zM348.1 160L256 67.9 256 136c0 13.3 10.7 24 24 24l68.1 0zM240 380l32 0c33.1 0 60 26.9 60 60s-26.9 60-60 60l-12 0 0 28c0 11-9 20-20 20s-20-9-20-20l0-128c0-11 9-20 20-20zm32 80c11 0 20-9 20-20s-9-20-20-20l-12 0 0 40 12 0zm96-80l32 0c28.7 0 52 23.3 52 52l0 64c0 28.7-23.3 52-52 52l-32 0c-11 0-20-9-20-20l0-128c0-11 9-20 20-20zm32 128c6.6 0 12-5.4 12-12l0-64c0-6.6-5.4-12-12-12l-12 0 0 88 12 0zm76-108c0-11 9-20 20-20l48 0c11 0 20 9 20 20s-9 20-20 20l-28 0 0 24 28 0c11 0 20 9 20 20s-9 20-20 20l-28 0 0 44c0 11-9 20-20 20s-20-9-20-20l0-128z"/>
                    </svg>
                </a>
            ';
        }

        return $result;
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
                    ->setTableId('requisition_globals-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
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
            ->title('Folio')
            ->searchable(true),
            Column::make('suppliers')
            ->title('Proveedores')
            ->name('suppliers.name')
            ->searchable(true),
            Column::make('total_amount')
            ->title('Total')
            ->name('total_amount')
            ->searchable(false),
            Column::make('created_at')
            ->title('Fecha generada')
            ->addClass('text-center')
            ->searchable(false),
            Column::make('status_name')
            ->title("Estatus")
            ->name('requisition_global_statuses.name')
            ->addClass('text-center'),
        ];

        $columns = array_merge($columns, [
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center')
            ->title('Acciones'),
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
        return 'Requisition_Globals' . date('YmdHis');
    }

    //HELPERS
    private function verifyRoleHasNotReviewed(int $requisition_global_id, string $currentRoleName){
        $requisition_global = RequisitionGlobal::where('id', $requisition_global_id)->first();

        return $requisition_global->roleHasNotVerified($currentRoleName);
    }
}
