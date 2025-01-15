<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Crear flujo
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/sass/input-inline.scss'])

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Crear flujo</h5>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('f_fluxes.store') }}">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <div class="w-50">
                            @include("f_fluxes.fields")
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('f_fluxes.index')}}" class="btn btn-dark">Cancelar</a>
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
        @vite(['resources/js/autocomplete.js'])
        @vite(['resources/js/f_fluxes.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>