<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Modificar usuario
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
                <h5 class="card-title">Modificar usuario</h5>
                <form class="row g-3 needs-validation" novalidate method="POST" enctype="multipart/form-data" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            <a href="{{route('contracts.exportContract', [$user->id, 1])}}" class="btn btn-dark">Cancelar</a>
                            @include("users.fields")

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('users.index')}}" class="btn btn-dark">Cancelar</a>
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
        @vite('resources/js/users/departamentSelect.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>