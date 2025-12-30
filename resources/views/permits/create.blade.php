<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Crear permiso
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
                <h5 class="card-title">Crear permiso</h5>
                <form id="permit_form" class="row g-3 needs-validation" novalidate method="POST"  enctype="multipart/form-data" action="{{ route('permits.store')  }}" >
                    @csrf
                    <div class="d-flex flex-column justify-content-center">
                        <div class="w-100">
                            <div class="row mb-2">
                                <b class="mb-2">INSTRUCCIONES:</b>
                                <p>Para <b>salidas tempranas / retardos,</b> ingrese la fecha de entrada, fecha de salida, su motivo y la característica de descuento que aplique.
                                </p>
                                <p>Para <b>ausentarse durante uno o mas días</b>, ingrese la fecha de entrada como el primer día ausentado, la fecha de salida como su ultimo día ausentado, 
                                    su motivo, y la característica de descuento que aplique.</p>

                                <p>Incluya las notas de horas pendientes en observaciones.</p>
                            </div>

                            @include("permits.fields")
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('permits.index')}}" class="btn btn-dark">Cancelar</a>
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
        @vite('resources/js/signature.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>