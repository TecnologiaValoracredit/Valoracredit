<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Crear flujo
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/sass/input-inline.scss'])
        @vite(['resources/sass/f_fluxes.scss'])

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Importar flujo</h5>
                <form id="upload-form" method="POST" enctype="multipart/form-data" class="p-3 bg-light rounded shadow-sm">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label fw-bold">Seleccionar archivo Excel:</label>
                        <input class="form-control" type="file" name="file" id="file" required>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-upload"></i> Cargar Excel
                        </button>
                    </div>
                </form>

                @if ($allowAddBeneficiaries)
                    <a id="openBeneficiaryModal" class="btn mt-3 btn-secondary">Agregar beneficiario</a>
                @endif
                <form class="row g-3" method="POST" action="{{ route('f_fluxes.storeFromExcel') }}">
                    @csrf
                    <div id="table-excel" class="bg-light shadow-sm rounded">
                    </div> <!-- Aquí se cargará la tabla -->

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{route('f_fluxes.index')}}" class="btn btn-dark">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="beneficiaryModal" class="row g-3 needs-validation" novalidate method="POST">
        <x-modal id="addBeneficiaryModal" title="Agregar Beneficiario" size="md">
            <!-- Este contenido se llenará por AJAX -->
        </x-modal>
    </form>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/js/autocomplete.js'])
        @vite(['resources/js/f_fluxes_excel.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>