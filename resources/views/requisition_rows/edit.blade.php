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
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('requisitions.store') }}">
                    @csrf
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
                                        <a href="{{route('requisition_rows.create')}}" class="btn btn-success text-end">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                            Agregar Producto
                                        </a>
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
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>    
        {!! $requisitionRowsDT["scripts"] !!}
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>