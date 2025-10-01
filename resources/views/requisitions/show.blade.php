<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Detalle de Requisición
    </x-slot>

    <input type="hidden" id="requisition_id" value="{{$requisition->id}}">

    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <!-- Puedes agregar estilos personalizados aquí si quieres -->
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detalle de requisición</h5>

                <div class="d-flex justify-content-center">
                    <div class="w-100">
                        {{-- Reutilizamos los mismos fields pero forzando readonly --}}
                        @include("requisitions.fields", ["readonly" => true])

                        <hr>
                        <div class="row my-3">
                            <div class="col">
                                <h5>Productos</h5>
                            </div>
                        </div>

                        {{-- Mostramos la tabla de productos --}}
                        {!! $requisitionRowsDT["view"] !!}

                        @if(auth()->user()->role_id == 3)
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{route('requisitions.index')}}" class="btn btn-dark">Regresar</a>
                                <button class="btn btn-danger" onclick="denyRequisition({{$requisition->id}}, 4)">Rechazar</button>
                                <button class="btn btn-primary" onclick="approveRequisition({{$requisition->id}}, 3)">Aprobar</button>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div id="exampleModal-body"><!-- contenido AJAX aquí --></div>
            </div>
        </div>
    </div>

    <x-slot:footerFiles>    
        {!! $requisitionRowsDT["scripts"] !!}
        @vite(['resources/js/requisitions/generals.js'])

    </x-slot>

</x-base-layout>
