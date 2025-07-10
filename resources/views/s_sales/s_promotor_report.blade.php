<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="s_coordinator_reports">
    <x-slot:pageTitle>
        Reporte por coordinadores
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
   
        @include('components.custom.forms.filters', [
            "rows" => [
                [
                    [
                        "id" => "year",
                        "name" => "year",
                        "label" => "Año",
                        "type" => "select",
                        "class" => "col-6",
                        "elements" => collect(range(2020, date('Y')))->mapWithKeys(fn($year) => [$year => (string)$year])->toArray(),
                        "value" => "2"
                    ],
                ],
            ]
        ])

        <!-- Tabla de Datos -->
        <div class="card">
            <div class="card-body">
                
                <h4 class="m-3 mx-1">Reporte por promotor e institución</h4>
                
                <div id="table-promotors" style="overflow-x: auto; width: 100%;">
                    {!! $table !!}
                </div>

            </div>
        </div>
    </div>
          

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/js/s_promotor_reports.js'])

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
