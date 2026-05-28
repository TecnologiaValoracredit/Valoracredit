<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="users">

    <x-slot:pageTitle>
        Cambiar estatus de Vacaciones
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/accordions.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Cambiar estatus de Vacaciones</h5>
                </div>

                @include('vacations.showable.info')

                <form id="form" class="row mb-2" novalidate method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="col-md-12 mb-4">
                        @include("components.custom.forms.textarea", [
                            "id" => 'notes',
                            "name" => 'notes',
                            "type" => "textarea",
                            "placeholder" => "Notas...",
                            "label" => "Notas",
                            "required" => false,
                            "value" => old('notes'),
                            "invalid_feedback" => "El campo es requerido"
                        ])                                
                    </div>
                    <div class="col-md-12 d-flex justify-content-center gap-5">
                        <button class="btn btn-primary w-15" type="submit"
                            form="form" formaction="{{ route('vacations.approve', $vacation->id) }}">
                            {{ $approveAs ?? "No especificado" }}
                        </button>
                        <button class="btn btn-danger w-15" type="submit"
                        form="form" formaction="{{ route('vacations.deny', $vacation->id) }}">
                            Rechazar
                        </button>
                    </div>           
                </form>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>