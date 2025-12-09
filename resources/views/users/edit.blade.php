<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Modificar usuario
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
        <input type="hidden" id="user_id" value="{{$user->id}}">
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Modificar usuario</h5>
                <form id="user_form" class="row g-3 needs-validation" novalidate method="POST" enctype="multipart/form-data" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex flex-column justify-content-center">
                        <div class="w-100">
                            @include("users.fields")

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('users.index')}}" class="btn btn-dark">Cancelar</a>
                                <button id="form_button" type="submit" class="btn btn-primary">Guardar</button>
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
        @vite('resources/js/users/contracts.js')
        @vite('resources/js/users/user_fields.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>