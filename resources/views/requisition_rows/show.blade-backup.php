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
                <h5 class="card-title">Detalles de Requisición - {{$requisition->id ?? ""}}</h5>

                <div class="row">
                    <div class="col-md-4">
                        <!-- Responsable -->
                        <div class="details-section">
                            <label for="Responsable" class="form-label"><strong>Responsable</strong></label>
                            <p id="Responsable">{{ $requisition->created_by_name ?? 'No asignado' }}</p>
                        </div>

                        <!-- Fecha -->
                        <div class="details-section">
                            <label for="Fecha" class="form-label"><strong>Fecha</strong></label>
                            <p id="Fecha">
                                {{ $requisition->application_date ? \Carbon\Carbon::parse($requisition->application_date)->format('d/M/Y') : 'Sin fecha definida' }}
                            </p>
                        </div>


                        <!-- Departamento -->
                        <div class="details-section">
                            <label for="Departamento" class="form-label"><strong>Departamento</strong></label>
                            <p id="Departamento">{{ $requisition->departament->name ?? 'Sin departamento' }}</p>
                        </div>

                         <!-- Sucursal -->
                         <div class="details-section">
                            <label for="Sucursal" class="form-label"><strong>Sucursal</strong></label>
                            <p id="Sucursal">{{ $requisition->branch->name ?? 'Sin descripción ' }}</p>
                        </div>

                        <!-- Descripción -->
                        <div class="details-section">
                            <label for="Producto" class="form-label"><strong>Producto</strong></label>
                            <p id="Proveedor"> <strong>Proveedor : </strong> {{ $requisition_row->supplier->name ?? 'Sin proveedor ' }}</p>
                            <p id="Descripción"> <strong>Descripción : </strong> {{ $requisition_row->description ?? 'Sin descripción ' }}</p>
                            <p id="PrecioUnidad"><strong>Precio unitario : </strong>{{ $requisition_row->unit_price ?? 'Sin precio ' }}</p>
                            <p id="Cantidad"><strong>Cantidad : </strong>{{ $requisition_row->amount ?? 'Sin cantidad ' }}</p>
                            <p id="URL"><strong>URL del producto :  </strong>{{ $requisition_row->url ?? 'Sin url ' }}</p>
                            <p id="URL"><strong>Incluye IVA :  </strong>{{ $requisition_row->include_iva ? 'Sí' : 'No' }}</p>
                            <p id="Precio"><strong>Subtotal:  </strong>{{ $requisition_row->subtotal ?? 'Sin Subtotal ' }}</p>
                        </div>

                        @if($requisition->requisitionRowOptionals->count() > 0)
                          @foreach($requisition->requisitionRowOptionals as $requisition_row)

                        <div class="details-section">
                            <label for="Producto" class="form-label"><strong>Producto</strong></label>
                            <p id="Proveedor"><strong>Proveedor: </strong>{{ $requisition_row->supplier->name ?? 'Sin proveedor' }}</p>
                            <p id="Descripción"><strong>Descripción: </strong>{{ $requisition_row->description ?? 'Sin descripción' }}</p>
                            <p id="PrecioUnidad"><strong>Precio unitario: </strong>{{ $requisition_row->unit_price ?? 'Sin precio' }}</p>
                            <p id="Cantidad"><strong>Cantidad: </strong>{{ $requisition_row->amount ?? 'Sin cantidad' }}</p>
                            <p id="URL"><strong>URL del producto: </strong>{{ $requisition_row->url ?? 'Sin URL' }}</p>
                            <p id="IncluyeIva"><strong>Incluye IVA: </strong>{{ $requisition_row->include_iva ? 'Sí' : 'No' }}</p>
                            <p id="Subtotal"><strong>Subtotal: </strong>{{ $requisition_row->subtotal ?? 'Sin subtotal' }}</p>
                        </div>
                        @endforeach
                            @else
                            <p>No hay filas opcionales disponibles.</p>
                        @endif


                        

                        

                <!-- Botón para Generar Código QR -->
               
            </div>
        </div>
    </div>

    @php
    // Sumar los subtotales de las filas normales
    $total = $requisition->requisitionRows->sum('subtotal');

    // Sumar los subtotales de las filas opcionales
    $total += $requisition->requisitionRowOptional->sum('subtotal');
@endphp

<div class="row mt-7">
    <div class="col-md-3 col-md-4">
        <h4 class="text-right">Total:</h4>
        <input type="text" class="form-control text-right font-weight-bold" 
               value="{{ number_format($total, 2) }}" readonly>
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


    

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <!-- Agrega aquí cualquier script adicional si es necesario -->
        <!-- Incluir JS de Bootstrap y dependencias (jQuery y Popper.js) -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>
