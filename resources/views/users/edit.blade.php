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
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("users.fields")
                            <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                            <hr>
                            <h5>Cuentas bancarias del usuario</h5>
                            <div class="d-flex mt-2 mb-2">
                                <div>
                                    @include("components.custom.forms.input-inline-select", [
                                        "id" => "bank_id",
                                        "name" => "bank_id",
                                        "value" => isset($user) ? $user->bank_id :  old("bank_id"),
                                        "elements" => $banks,
                                        "label" => "Institución",
                                        "invalid_feedback" => "El campo es requerido"
                                    ])
                                </div>
                                <div>
                                     @include("components.custom.forms.input-inline", [
                                        "id" => "account_number",
                                        "name" => "account_number",
                                        "type" => "number",
                                        "label" => "Cuenta de banco",
                                        "invalid_feedback" => "El campo es requerido",
                                        "width" => 150,
                                    ])
                                </div>
                                <div>
                                    <a class="btn btn-success" onclick="addBankDetails()">+</a>
                                </div>
                            </div>

                            {!! $bankDetailDT["view"] !!}
                            

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
        {!! $bankDetailDT["scripts"] !!}

        @vite(['resources/js/users/generals.js'])

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>