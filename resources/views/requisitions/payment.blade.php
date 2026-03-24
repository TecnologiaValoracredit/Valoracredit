<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Subir Pago
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
                <h5 class="card-title">Subir Pago</h5>
                <form id="form" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate method="POST" action="{{ route('requisitions.uploadPayment', $requisition->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-50">
                            <div class="mb-2">
                                @include("components.custom.forms.input", [
                                    "id" => "payment_voucher",
                                    "name" => "payment_voucher",
                                    "type" => "file",
                                    "placeholder" => "Comprobante...",
                                    "label" => "Comprobante",
                                    "required" => true,
                                    "accept" => "image/*",
                                    "value" => old("name"),
                                    "invalid_feedback" => "El campo es requerido"
                                ])
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                            <a href="{{route('requisitions.index')}}" class="btn btn-dark">Cancelar</a>
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
        @vite('resources/js/requisitions/payment.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>