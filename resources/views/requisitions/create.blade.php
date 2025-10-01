<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Agregar requisición
    </x-slot>

    <input type="hidden" id="requisition_id" value="{{$requisition->id}}">



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
                <h5 class="card-title">Crear requisición</h5>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('requisitions.update', $requisition) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("requisitions.fields")

                            <hr>
                            <div class="row my-3">
                                <div class="col">
                                    <h5>Productos</h5>
                                </div>
                                <div class="col">
                                    <div class="text-end">
                                        <!-- Button trigger modal -->
                                        <button type="button" title="Agregar" class="btn btn-primary open-modal" onclick="createModal()">
                                            Agregar producto
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            {!! $requisitionRowsDT["view"] !!}

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('requisitions.index')}}" class="btn btn-dark">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
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

    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>    
        {!! $requisitionRowsDT["scripts"] !!}
        @vite(['resources/js/requisitions/generals.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>