<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="r_indicator_final">
    <x-slot:pageTitle>
        Reporte de indicadores
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        @vite(['resources/sass/datatables.scss'])
        <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <!-- Tabla de Datos -->
        <div class="card">
            <div class="card-body">
                @include('components.custom.forms.filters', [
                    "rows" => [
                        [
                            [
                                "id" => "year",
                                "name" => "year",
                                "label" => "Año",
                                "type" => "select",
                                "class" => "col-6",
                                "elements" => collect(range(2025, date('Y')))->mapWithKeys(fn($year) => [$year => (string)$year])->toArray(),
                                "value" => date("Y")
                            ],
                            [
                                "id" => "month",
                                "name" => "month",
                                "label" => "Mes",
                                "type" => "select",
                                "class" => "col-6",
                                "elements" => [1 => "Enero",2 => "Febrero",3 => "Marzo",4 => "Abril",5 => "Mayo",6 => "Junio",7=> "Julio",8 => "Agosto",9 => "Septiembre",10 => "Octubre",11 => "Noviembre",12 => "Diciembre"],
                                "value" => date("n")
                            ],
                        ],
                    ]
                ])
                <div class="simple-tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Concentrado</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Dashboard</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="mt-3">
                                {!! $rIndicatorFinalDT["view"] !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="mt-3">
                                {!! $rIndicatorDT["view"] !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
          

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {!! $rIndicatorDT["scripts"] !!}
        {!! $rIndicatorFinalDT["scripts"] !!}

        <script>
            window.loadDatatable = function() {
                if(window.LaravelDataTables != undefined) {
                    window.LaravelDataTables["r_indicator_final-table"].on('preXhr.dt', function ( e, settings, data ) {
                        $('.datatable-filter').each(function(index, el) {
                            data[$(el).prop('name')] = $(el).val();
                        });
                    });
                    window.LaravelDataTables["r_indicator-table"].on('preXhr.dt', function ( e, settings, data ) {
                        $('.datatable-filter').each(function(index, el) {
                            data[$(el).prop('name')] = $(el).val();
                        });
                    });
                }
            }

            window.filterDT = () => {
                if(window.LaravelDataTables != undefined) {
                    loadDatatable();
                    window.LaravelDataTables["r_indicator-table"].draw();
                    window.LaravelDataTables["r_indicator_final-table"].draw();
                }
            }

            window.clearFilters = () => {
                $('.datatable-filter').each(function(index, el) {
                    $(el).val("");
                });
            }

        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
