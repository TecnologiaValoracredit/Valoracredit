<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="s_institution_reports">
    <x-slot:pageTitle>
        Reporte por institución 
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
                        "type" => "select",
                        "class" => "col-6",
                        "elements" => [2020 => "2020", 2021 => "2021", 2022 => "2022", 2023 => "2023", 2024 => "2024"],
                        "value" => "2"
                    ],
                    [
                        "id" => "institution_id",
                        "name" => "institution_id",
                        "label" => "Institución",
                        "type" => "select",
                        "class" => "col-6",
                        "elements" => $institutions,
                        "value" => "2"
                    ],
                ],
            ]
        ])
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Reporte por institución </h5>
                </div>

                {{ $dataTable->table() }}

                <hr>

                <table>
                    <thead>
                        <th>Año</th>
                        <th>Ventas</th>
                        <th>Meses</th>
                        <th>Promedio</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2022</td>
                            <td>1000</td>
                            <td>10</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>2023</td>
                            <td>1000</td>
                            <td>10</td>
                            <td>100</td>
                        </tr>
                        <tr>
                            <td>2024</td>
                            <td>1000</td>
                            <td>10</td>
                            <td>100</td>
                        </tr>
                    </tbody>
                </table>
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
