<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="h_hardwares">
    <x-slot:pageTitle>
        Activos
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        
        <!--  END CUSTOM STYLE FILE  -->

    </x-slot>
   

    <div class="row layout-top-spacing">
    @include('components.custom.forms.filters', [
            "rows" => [
                [
                    [
                        "id" => "initial_purchase_date",
                        "name" => "initial_purchase_date",
                        "label" => "Comprados desde",
                        "type" => "date",
                        "class" => "col-6"
                    ],
                    [
                        "id" => "final_purchase_date",
                        "name" => "final_purchase_date",
                        "label" => "Comprados hasta",
                        "type" => "date",
                        "class" => "col-6"
                    ],
                    [
                        "id" => "user_id",
                        "name" => "user_id",
                        "label" => "Propietario",
                        "type" => "select",
                        "elements" => $users,  
                        "class" => "col-6",
                        "value" => 0
                    ],

                    [
                        "id" => "h_device_type_id",
                        "name" => "h_device_type_id",
                        "label" => "Tipo",
                        "type" => "select",
                        "elements" => $h_device_types,  
                        "class" => "col-6",
                        "value" => 0
                    ],

                    [
                        "id" => "h_brand_id",
                        "name" => "h_brand_id",
                        "label" => "Marca",
                        "type" => "select",
                        "elements" => $h_brands,  
                        "class" => "col-6",
                        "value" => 0
                    ],


                ],
            ]
        ])
        
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Hardware</h5>
                    @if($allowAdd)
                    <a href="{{route('h_hardwares.create')}}" class="btn btn-success text-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        Agregar
                    </a>
                    @endif
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/filters.js'])

        <!-- Modal for Image Preview -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Imagen del Activo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="hardwareImage" src="" alt="Imagen del Hardware" class="img-fluid w-100">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script to handle image modal -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                const imageModalElement = document.getElementById('hardwareImage');

                // Function to open modal with image
                window.showImageModal = function(imagePath) {
                    imageModalElement.src = imagePath;  // Set image source
                    imageModal.show();  // Show modal
                }
            });
        </script>

    </x-slot>
    
</x-base-layout>
