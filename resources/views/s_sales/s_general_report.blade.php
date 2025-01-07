<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="s_general_reports">
    <x-slot:pageTitle>
        Reporte General
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
                        "elements" => [2020 => "2020", 2021 => "2021", 2022 => "2022", 2023 => "2023", 2024 => "2024"],
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
        <div style="position: relative; height: 400px; width: 100%; margin-top: 20px;">
            <div id="buttonContainer" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                <button id="downloadBtn" class="btn btn-light">
                    <i class="fas fa-download" style="color: green; margin-right: 5px;"></i> Descargar Imagen
                </button>
            </div>

        <!-- Contenedor de la gráfica -->
        <div style="height: 400px; width: 100%; margin-top: 20px;">
            <canvas id="generalReportGraphic"></canvas>
        </div>
    </div>
        </div>
            </div>
          

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/filters.js'])
        @vite(['resources/js/s_general_reports.js'])
        @vite(['resources/js/s_general_report_graphics.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
