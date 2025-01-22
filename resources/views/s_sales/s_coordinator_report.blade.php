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
        <!-- Filtros -->
        
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
            {{ $dataTable->table() }}

            <!-- Boton descargar -->
            <div style="position: relative;">
                <div id="buttonContainer" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                    <button id="downloadBtn" class="btn btn-light">
                        <i class="fas fa-download" style="color: green; margin-right: 5px;"></i> Descargar Imagen
                    </button>
                </div>

                <!-- Contenedor de la gráfica -->
                    <canvas width="1000" id="coordinatorReportGraphic"></canvas>
                </div>
            </div>
        </div>
    </div>
          

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/filters.js'])
        @vite(['resources/js/s_coordinator_reports.js'])
        @vite(['resources/js/s_coordinator_report_graphics.js'])

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
