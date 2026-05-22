<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Crear Vacación
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
                <h5 class="card-title">Crear Vacación</h5>
                <form id="form" class="row g-3 needs-validation" novalidate method="POST"  enctype="multipart/form-data" action="{{ route('vacations.store')  }}" >
                    @csrf
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("vacations.fields")
                            <div class="d-flex justify-content-center gap-5 mt-4">
                                <button id="sendOnCreationBtn" onclick="sendOnCreation()" class="btn btn-primary">Crear y enviar</button>
                                <button type="submit" class="btn btn-secondary">Crear borrador</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite('resources/js/vacations/create.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>