<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="f_fluxes">
    <x-slot:pageTitle>
        Flujo 
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    @include('components.custom.forms.filters', [
        "rows" => [
            [
                [
                    "id" => "initial_accredit_date",
                    "name" => "initial_accredit_date",
                    "label" => "Flujos desde",
                    "type" => "date",
                    "class" => "col-6"
                ],
                [
                    "id" => "final_accredit_date",
                    "name" => "final_accredit_date",
                    "label" => "Flujos hasta",
                    "type" => "date",
                    "class" => "col-6"
                ],
                [
                    "id" => "f_movement_type",
                    "name" => "f_movement_type",
                    "label" => "Tipo de movimiento",
                    "type" => "select",
                    "elements" => $f_movement_types,  
                    "class" => "col-6",
                    "value" => request('f_movement_type')  
                ],
                [
                    "id" => "f_status_id",
                    "name" => "f_status_id",
                    "label" => "Estatus",
                    "type" => "select",
                    "elements" => $f_statuses,  
                    "class" => "col-6",
                    "value" => request('f_status_id')  
                ],

                
            ],
        ]
    ])
    
    @if(auth()->user()->hasPermissions("f_fluxes.showExpenses") || auth()->user()->hasPermissions("f_fluxes.showIncome"))
    <div class="row layout-top-spacing">
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Flujo</h5>
                    @if($allowAdd)
                        <a href="{{route('f_fluxes.create')}}" class="btn btn-success text-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Agregar
                        </a>
                    @endif
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@else
    <div class="alert alert-warning">
        No tienes permisos para ver esta información.
    </div>
@endif

    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
    @vite(['resources/js/filters.js'])
    @vite(['resources/js/f_flux_status.js'])
</x-base-layout>