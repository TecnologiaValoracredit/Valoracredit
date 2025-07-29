<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="commissions">

    <x-slot:pageTitle>
        Modificar promotor
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
        <input type="hidden" name="user_id" id="user_id" value="{{$s_promotor->user->id}}">

        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Modificar promotor</h5>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('s_promotors.update', $s_promotor->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("s_promotors.fields")

                            @if(auth()->user()->hasPermissions("commissions.editCommissionPercentages"))
                                <hr>
                                <h5>Comisiones diferentes por institución</h5>
                                <div class="d-flex mt-2 mb-2">
                                    <div>
                                        @include("components.custom.forms.input-inline-select", [
                                            "id" => "institution_id",
                                            "name" => "institution_id",
                                            "elements" => $institutions,
                                            "value" => isset($s_promotor) ? $s_promotor->user->institution_id :  old("institution_id"),
                                            "label" => "Institución",
                                            "invalid_feedback" => "El campo es requerido"
                                        ])
                                    </div>
                                    <div>
                                        @include("components.custom.forms.input-inline", [
                                            "id" => "percentage",
                                            "name" => "percentage",
                                            "type" => "number",
                                            "label" => "Porcentaje",
                                            "invalid_feedback" => "El campo es requerido",
                                            "width" => 150,
                                        ])
                                    </div>
                                    <div>
                                        <a class="btn btn-success" onclick="addInstitution()">+</a>
                                    </div>
                                </div>
                                {!! $institutionDT["view"] !!}
                            @endif

                            <hr>
                            <h5>Nombres anteriores</h5>
                            <div class="d-flex mt-2 mb-2">
                                <div>
                                     @include("components.custom.forms.input-inline", [
                                        "id" => "s_user_name",
                                        "name" => "s_user_name",
                                        "type" => "text",
                                        "label" => "Nombre",
                                        "invalid_feedback" => "El campo es requerido",
                                        "width" => 150,
                                    ])
                                </div>
                                <div>
                                    <a class="btn btn-success" onclick="addName()">+</a>
                                </div>
                            </div>
                            {!! $sUserNameDT["view"] !!}

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('s_promotors.index')}}" class="btn btn-dark">Cancelar</a>
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
        {!! $institutionDT["scripts"] !!}
        {!! $sUserNameDT["scripts"] !!}

        @vite(['resources/js/commissions/generals.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>