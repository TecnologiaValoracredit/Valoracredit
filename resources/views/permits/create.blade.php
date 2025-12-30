<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Crear permiso
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
                <h5 class="card-title">Crear permiso</h5>
                <form id="permit_form" class="row g-3 needs-validation" novalidate method="POST"  enctype="multipart/form-data" action="{{ route('permits.store')  }}" >
                    @csrf
                    <div class="d-flex flex-column justify-content-center">
                        <div class="w-100">
                            <div class="row mb-2">
                                <b>PARA SALIDAS TEMPRANAS O RETARDOS:</b>
                                <p>Ingrese la hora de entrada y hora de salida, su motivo y la característica de descuento que aplique.
                                </p>

                                <b>PARA AUSENTARSE UNO, O MAS DÍAS:</b>
                                <p>Ingrese en hora de entrada el dia que faltará, y en fecha de salida el último día que se ausentará. <br>
                                Por ejemplo, si llega a faltar desde el 12/12/2025, hasta el 14/12/2025, ingresará en fecha de entrada 12/12/2025 9:00 AM, y en fecha de salida 14/12/2025 9:00 AM. <br>
                                <b>MUY IMPORTANTE</b> marcar la hora de entrada de ambos dias como inicio del turno, 9 AM, para un correcto calculo de horas pendientes. <br>
                                Por ultimo, en caso de faltar solamente un día, siga los mismos pasos anteriores, pero usando el mismo día en que planea faltar.</p>
                            </div>

                            @include("permits.fields")
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('permits.index')}}" class="btn btn-dark">Cancelar</a>
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
        @vite('resources/js/signature.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>