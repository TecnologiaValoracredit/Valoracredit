
<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Agregar requisición
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
                <h5 class="card-title">Crear requisición</h5>
                <form id="requisition_form" class="row g-3 needs-validation" novalidate method="POST" action="{{ route('requisitions.store') }}">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("requisitions.fields")

                            <hr>
                            <div class="row my-3 m-0 mb-4">
                                <div class="col">
                                    <h5>Productos</h5>
                                </div>
                                <div class="col">
                                    <div class="text-end">
                                        <!-- Button trigger modal -->
                                        <button id="show_btn" type="button" title="Agregar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reg-modal">
                                            Agregar producto
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="overflow-auto">
                                <table class="table">
                                    <thead>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Incluya IVA</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody id="table_body">
                                    </tbody>
                                </table>
                            </div>

                            @if (!auth()->user()->path_signature)
                                @include('components.custom.forms.input-signature')
                            @endif

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('requisitions.index')}}" class="btn btn-dark">Cancelar</a>
                                <button id="submit_btn" type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reg-modal" aria-labelledby="modal-title" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                @include('requisition_rows.modal_add')
            </div>
        </div>
    </div>

    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>