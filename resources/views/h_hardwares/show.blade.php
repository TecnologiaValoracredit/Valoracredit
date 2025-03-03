<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        Detalles del Activo
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <style>
            .card {
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            .card-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: #2c3e50;
                margin-bottom: 1rem;
            }
            .form-label {
                font-weight: 600;
                color: #34495e;
                margin-bottom: 0.25rem;
            }
            .details-section {
                margin-bottom: 1rem;
            }
            .details-section p {
                margin-bottom: 0;
                color: #555;
            }
            .btn-qr {
                background-color: #3498db;
                color: white;
                border: none;
                transition: background-color 0.3s ease;
                padding: 8px 16px;
                border-radius: 5px;
                margin-top: 1rem;
            }
            .btn-qr:hover {
                background-color: #2980b9;
            }
            .img-thumbnail {
                border: 2px solid #ddd;
                border-radius: 8px;
                padding: 5px;
                max-width: 200px;
                height: auto;
                margin-top: 1rem;
                cursor: pointer;
            }
            .border-st {
                border: 1px dotted  #cccccc;
                border-radius: 10px;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detalles de Activo - {{$h_hardware->name ?? ""}}</h5>

                <div class="row">
                    <div class="col-md-4">
                        <!-- Responsable -->
                        <div class="details-section">
                            <label for="user_id" class="form-label"><strong>Responsable</strong></label>
                            <p id="user_id">{{ $h_hardware->user->name ?? 'No asignado' }}</p>
                        </div>

                        <!-- Color -->
                        <div class="details-section">
                            <label for="color" class="form-label"><strong>Color</strong></label>
                            <p id="color">{{ $h_hardware->color ?? 'Sin color definido' }}</p>
                        </div>

                        <!-- Número de Serie -->
                        <div class="details-section">
                            <label for="serial_number" class="form-label"><strong>Número de Serie (original)</strong></label>
                            <p id="serial_number">{{ $h_hardware->serial_number ?? 'Sin número de serie definido' }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                         <!-- Número de Serie Generado -->
                        <div class="details-section">
                            <label for="custom_serial_number" class="form-label"><strong>Número de Serie Generado</strong></label>
                            <p id="custom_serial_number">{{ $h_hardware->custom_serial_number ?? 'Sin número de serie definido' }}</p>
                        </div>

                        <!-- Fecha de Compra -->
                        <div class="details-section">
                            <label for="purchase_date" class="form-label"><strong>Fecha de Compra</strong></label>
                            <p id="purchase_date">    {{ $h_hardware->purchase_date ? date('d/m/Y', strtotime($h_hardware->purchase_date)) : 'Sin fecha definida' }}
                            </p>
                        </div>

                        <!-- Marca -->
                        <div class="details-section">
                            <label for="h_brand_id" class="form-label"><strong>Marca</strong></label>
                            <p id="h_brand_id">{{ $h_hardware->hBrand->name ?? 'No asignado' }}</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                          <!-- Tipo de Dispositivo -->
                        <div class="details-section">
                            <label for="h_device_type_id" class="form-label"><strong>Tipo de activo</strong></label>
                            <p id="h_device_type_id">{{ $h_hardware->hDeviceType->name ?? 'No asignado' }}</p>
                        </div>


                        <!-- Compañía -->
                        <div class="details-section">
                            <label for="company_id" class="form-label"><strong>Empresa</strong></label>
                            <p id="company_id">{{ $h_hardware->company->name ?? 'No asignado' }} - Sucursal {{ $h_hardware->branch->name ?? 'No asignado' }}</p>
                            <p>{{ $h_hardware->company->location ?? 'No asignado' }}</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="w-100 border-st p-3">
                         <!-- Especificaciones -->
                         <div class="details-section">
                            <label for="specifications" class="form-label"><strong>Especificaciones</strong></label>
                            <p id="specifications">{{ $h_hardware->specifications ?? 'Sin especificaciones' }}</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between gap-2">
                    <div class="w-100 border-st p-3">
                        <!-- Imagen -->
                        @if($h_hardware->image)
                            <div class="details-section">
                                <label for="image" class="form-label"><strong>Imagen</strong></label>
                                <div>
                                    <img src="{{ asset('storage/' . $h_hardware->image) }}" alt="Imagen del hardware" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#imageModal">
                                </div>
                            </div>
                        @endif
                    </div>
                    

                <!-- Botón para Generar Código QR -->
               
            </div>
        </div>
    </div>

    <!-- Modal para imagen ampliada -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content custom-modal-background">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Imagen</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Imagen ampliada -->
                <img src="{{ asset('storage/' . $h_hardware->image) }}" alt="Imagen del hardware" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
    .custom-modal-background {
        background-color: #f8f9fa; /* Cambia este color al que prefieras */
        color: #333; /* Cambia el color del texto si es necesario */
        border-radius: 8px; /* Opcional: bordes redondeados */
    }
</style>


    <div class="text-center">
                    <a class="btn btn-qr" href="{{ route('h_hardwares.generateQrCode', $h_hardware->id) }}" target="_blank">
                        Generar Código QR
                    </a>
                </div>

    

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <!-- Agrega aquí cualquier script adicional si es necesario -->
        <!-- Incluir JS de Bootstrap y dependencias (jQuery y Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
