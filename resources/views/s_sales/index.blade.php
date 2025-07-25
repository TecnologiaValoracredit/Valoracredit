<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="s_sales">
    <x-slot:pageTitle>
        Ventas 
    </x-slot>


    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <!-- CONTENT HERE -->


        @include('components.custom.forms.filters', [
            "rows" => [
                [
                    [
                        "id" => "initial_grant_date",
                        "name" => "initial_grant_date",
                        "label" => "Otorgado desde",
                        "type" => "date",
                        "class" => "col-6"
                    ],
                    [
                        "id" => "final_grant_date",
                        "name" => "final_grant_date",
                        "label" => "Otorgado hasta",
                        "type" => "date",
                        "class" => "col-6"
                    ],
                ],
            ]
        ])
        
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Ventas</h5>
                </div>
                @if (auth()->user()->hasPermissions("s_sales.importExcel"))
                    <div class="d-flex justify-content-end m-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#exampleModal">
                            Subir excel
                        </button>
                    </div>
                    
                    {{-- Modal --}}
                    @include('s_sales.modal_excel')
                @endif 
                
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    

    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/filters.js'])

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>