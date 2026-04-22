<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Editar Requisición Global
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
<x-slot:headerFiles>
    <style>
        .table .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            opacity: 1;
        }

        #fixed-footer {
            transition: 
                transform 0.2s ease-in-out;
        }

        #fixed-footer:hover {
            transform: scale(1.1);
        }
    </style>
</x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Editar Requisición Global</h5>
                <form id="form" class="row g-3 needs-validation" novalidate method="POST" enctype="multipart/form-data" action="{{ route('requisition_globals.update', $requisition_global->id)  }}" >
                    @csrf
                    @method("PUT")
                    <div class="d-flex flex-column justify-content-center">
                        <div class="w-100">
                            @include('requisition_globals.fields')

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('requisition_globals.index')}}" class="btn btn-dark">Cancelar</a>
                                <button id="submit_btn" type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite('resources/js/requisition_globals/main.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>