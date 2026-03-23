<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Crear Requisiciones Globales
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Crear Requisiciones Globales</h5>

                <div class="overflow-auto">
                    <table class="table">
                        <thead>
                            <th>Folio</th>
                            <th>Fecha de pedido</th>
                            <th>Estatus</th>
                            <th>Total</th>
                        </thead>

                        <tbody>
                            @foreach ($requisitions as $requisition)
                            <td>{{ $requisition->folio }}</td>
                            <td>{{ date("d/m/Y", strtotime($requisition->request_date)) }}</td>
                            <td>{{ $requisition->lastLog->toStatusId->name }}</td>
                            <td>&dollar;{{ $requisition->amount }}</td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    
                </table>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>