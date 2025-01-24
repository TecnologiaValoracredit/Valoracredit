<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Detalles del Hardware
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
                <h5 class="card-title">Detalles del Hardware</h5>
                <div class="row g-3">

                    <!-- Mostrar los campos del hardware -->

                    <div class="col-md-6">
                        <label for="user_id" class="form-label"><strong>Responsable</strong></label>
                        <p id="user_id">
                            {{ \App\Models\User::find($h_hardware->user_id)?->name ?? 'No asignado' }}
                        </p>
                    </div>
                    <!-- Color -->

                    <div class="col-md-6">
                        <label for="color" class="form-label"><strong>Color</strong></label>
                        <p id="color">{{ $h_hardware->color ?? 'Sin color definido' }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="serial_number" class="form-label"><strong>Numero de serie</strong></label>
                        <p id="serial_number">{{ $h_hardware->serial_number ?? 'Sin numero de serie definido' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="custom_serial_number" class="form-label"><strong>Numero de serie generado</strong></label>
                        <p id="custom_serial_number">{{ $h_hardware->custom_serial_number ?? 'Sin numero de serie definido' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="purchase_date" class="form-label"><strong>Fecha de compra</strong></label>
                        <p id="purchase_date">{{ $h_hardware->purchase_date ?? 'Sin fecha definida' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="h_brand_id" class="form-label"><strong>Marca</strong></label>
                        <p id="h_brand_id">
                            {{ \App\Models\HBrand::find($h_hardware->h_brand_id)?->name ?? 'No asignado' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label for="h_device_type_id" class="form-label"><strong>Tipo de dispositivo</strong></label>
                        <p id="h_device_type_id">
                            {{ \App\Models\HDeviceType::find($h_hardware->h_device_type_id)?->name ?? 'No asignado' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <label for="specifications" class="form-label"><strong>Especificaciones</strong></label>
                        <p id="specifications">{{ $h_hardware->specifications ?? 'Sin especificaciones' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="color" class="form-label"><strong>Color</strong></label>
                        <p id="color">{{ $h_hardware->color ?? 'Sin color definido' }}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="company_id" class="form-label"><strong>Compañia</strong></label>
                        <p id="company_id">
                            {{ \App\Models\Company::find($h_hardware->company_id)?->name ?? 'No asignado' }}
                            <p>
                            {{ \App\Models\Company::find($h_hardware->company_id)?->location ?? 'No asignado' }}
                        </p>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="branch_id" class="form-label"><strong>Sucursal</strong></label>
                        <p id="branch_id">
                            {{ \App\Models\Branch::find($h_hardware->branch_id)?->name ?? 'No asignado' }}
                        </p>
                    </div>
                    
                    <!-- En el archivo show.blade.php donde muestras los detalles del hardware -->

              
                    <p>
                    <a class="btn btn-secondary col-md-3" href="{{ route('h_hardwares.generateQrCode', $h_hardware->id) }}" target="_blank">
                        Generar Código QR
                    </a>


                    


                    

                    
                    
                    

                   
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <!-- Agrega aquí cualquier script adicional si es necesario -->
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
