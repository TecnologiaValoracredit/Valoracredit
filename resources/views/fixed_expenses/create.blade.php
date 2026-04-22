<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Crear Gasto recurrente
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <style>
        .table .form-check-input:checked {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            opacity: 1;
        }
        </style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Crear Gasto recurrente</h5>
                <form id="form" class="row g-3 needs-validation" novalidate method="POST"  enctype="multipart/form-data" action="{{ route('fixed_expenses.store')  }}" >
                    @csrf
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            <div class="row mb-2">
                                <b class="mb-2">INSTRUCCIONES:</b>
                                <p>Cada Gasto recurrente toma como referencia una requisición ya creada previamente, independientemente de su estatus.</p>
                                <p>Cada Gasto recurrente debe tener <b>nombre</b> y <b>descripción</b> para identificarse correctamente.</p>
                                <p>Al usar un Gasto recurrente, este servirá como base para llenar automaticamente los datos de una requisición nueva.</p>
                            </div>
                            @include("fixed_expenses.fields")
                            
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('fixed_expenses.index')}}" class="btn btn-dark">Cancelar</a>
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
        @vite('resources/js/fixed_expenses/main.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>