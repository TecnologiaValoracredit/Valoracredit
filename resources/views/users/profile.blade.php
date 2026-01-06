<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="users">

    <x-slot:pageTitle>
        Perfil de Usuario
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/accordions.scss'])

        <style>
            .signature-img{
                max-width: 200px;
            }
        </style>

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Mi Perfil</h5>
                </div>

                <ul class="nav nav-tabs" id="navbar" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user-pane" type="button" role="tab">
                            INFORMACIÓN DE EMPLEADO
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="signature-tab" data-bs-toggle="tab" data-bs-target="#signature-pane" type="button" role="tab">
                            FIRMA
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents-pane" type="button" role="tab">
                            DOCUMENTOS
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="permits-tab" data-bs-toggle="tab" data-bs-target="#permits-pane" type="button" role="tab">
                            PERMISOS
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="h_hardware-tab" data-bs-toggle="tab" data-bs-target="#h_hardware-pane" type="button" role="tab">
                            ACTIVOS
                        </button>
                    </li>
                </ul>

                <div class="tab-content mb-2">
                    <div class="tab-pane fade show active" id="user-pane" role="tabpanel" aria-labelledby="user-tab">
                        <div class="row gy-3 mt-2">
                            @include('users.profile_custom_fields.data')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="signature-pane" role="tabpanel" aria-labelledby="signature-tab">
                        <div class="row gy-3 mt-2">
                            @include('users.profile_custom_fields.signature')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="documents-pane" role="tabpanel" aria-labelledby="documents-tab">
                        <div class="row gy-3 mt-2">
                            @include('users.profile_custom_fields.contracts')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="permits-pane" role="tabpanel" aria-labelledby="permits-tab">
                        <div class="row gy-3 mt-2">
                            @include('users.profile_custom_fields.permits')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="h_hardware-pane" role="tabpanel" aria-labelledby="h_hardware-tab">
                        <div class="row gy-3 mt-2">
                            @include('users.profile_custom_fields.h_hardware')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    @vite('resources/js/signature.js')

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>