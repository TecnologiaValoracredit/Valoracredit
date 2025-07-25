<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="commissions">
    <x-slot:pageTitle>
        Comisiones 
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <form action="{{ route('commissions.exportReport') }}">
        <div class="row layout-top-spacing">
        <!-- CONTENT HERE -->
            @include('components.custom.forms.filters', [
                "rows" => [
                    [
                        [
                            "id" => "initial_date",
                            "name" => "initial_date",
                            "label" => "Desde",
                            "type" => "date",
                            "class" => "col-6"
                        ],
                        [
                            "id" => "final_date",
                            "name" => "final_date",
                            "label" => "Hasta",
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
                        <h5 class="card-title">Comisiones</h5>
                        @if($allowExport)
                            <button type="submit" class="btn btn-success text-end">
                                Exportar comisiones a excel
                            </button>
                        @endif
                    </div>
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </form>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/filters.js'])

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>