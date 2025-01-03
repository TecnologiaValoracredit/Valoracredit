<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="s_general_reports">
    <x-slot:pageTitle>
        Reporte general 
    </x-slot>


    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
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
                        "type" => "text",
                        "class" => "col-6",
                        "value" => "2024"
                    ],
                ],
            ]
        ])
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Reporte general </h5>
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/filters.js'])
        @vite(['resources/js/s_general_reports.js'])

        <script>
            
           
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>