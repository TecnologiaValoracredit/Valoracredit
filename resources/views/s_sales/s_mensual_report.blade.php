<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="s_mensual_reports">
    <x-slot:pageTitle>
        Reporte mensual 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        @vite(['resources/sass/datatables.scss'])

        <style>
            .table tbody tr td{
                padding: 10px;
            }
            #s_sales-table th,
            #s_sales-table td {
                border-right: 1px solid #ddd; /* Línea vertical entre columnas */
            }

            #s_sales-table {
                border-collapse: collapse; /* Evita duplicar bordes */
            }

            #s_sales-table th:last-child,
            #s_sales-table td:last-child {
                border-right: none; /* Elimina la línea de la última columna */
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <!-- CONTENT HERE -->
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
                    [
                        "id" => "month",
                        "name" => "month",
                        "label" => "Mes",
                        "type" => "select",
                        "class" => "col-6",
                        "elements" => [1 => "Enero",2 => "Febrero",3 => "Marzo",4 => "Abril",5 => "Mayo",6 => "Junio",7=> "Julio",8 => "Agosto",9 => "Septiembre",10 => "Octubre",11 => "Noviembre",12 => "Diciembre"],
                        "value" => "2"
                    ],
                ],
            ]
        ])
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Reporte mensual </h5>
                </div>
                {{ $dataTable->table() }}
           
    </div>
    <!-- Boton descargar -->
    <div style="position: relative; height: 400px; width: 100%; margin-top: 20px;">
        <div id="buttonContainer" style="position: absolute; top: -10px; right: 10px; z-index: 10;">
            <button id="downloadBtn" class="btn btn-light">
                <i class="fas fa-download" style="color: green; margin-right: 5px;"></i> Descargar Imagen
            </button>
        </div>
        <!--Contenedor grafica -->
    <div style="height: 400px; width: 100%; margin-top: 20px;">
        <canvas id="grafica"></canvas>
    </div>
</div>
    </div>
        </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/filters.js'])
        @vite(['resources/js/s_mensual_reports.js'])
        @vite(['resources/js/s_mensual_report_graphics.js'])
        

        

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
