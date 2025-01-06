<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="s_general_reports">
    <x-slot:pageTitle>
        Reporte general 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        @vite(['resources/sass/datatables.scss'])
        <!-- Estilo para la tabla -->
        <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
        <!-- Importar jQuery desde un CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                {{ $dataTable->table() }}

                <!-- Contenedor de la gráfica -->
                <div id="container" style="height: 400px; margin-top: 20px;"></div>
      

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/filters.js'])
        @vite(['resources/js/s_general_reports.js'])
        @vite(['resources/js/s_general_report_graphics.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
