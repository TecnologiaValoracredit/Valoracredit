<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="users">

    <x-slot:pageTitle>
        Informacion de Vacaciones
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
                    <h5 class="card-title">Detalles de Vacaciones</h5>
                </div>

                @include('vacations.showable.info')

                @if ($canAction)
                    @if ($canDestroy)
                        <form id="destroy-form" method="POST">
                            @csrf
                            @method("DELETE")
                        </form>
                    @endif
                    <form id="form" class="row mb-2" novalidate method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                            <div class="col-md-12 d-flex justify-content-center gap-5">
                                <button class="btn btn-primary w-15" type="submit"
                                    form="form" formaction="{{ route('vacations.send', $vacation->id) }}">
                                    Enviar a revisión
                                </button>
                                @if ($canDestroy)
                                    <button class="btn btn-danger w-15" type="submit"
                                    form="destroy-form" formaction="{{ route('vacations.destroy', $vacation->id) }}">
                                        Eliminar
                                    </button>
                                @else
                                    <button class="btn btn-danger w-15" type="submit"
                                    form="form" formaction="{{ route('vacations.cancel', $vacation->id) }}">
                                        Cancelar
                                    </button>
                                @endif
                            </div>                            
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>