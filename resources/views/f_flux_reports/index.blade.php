<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="f_fluxes">
    
    <x-slot:pageTitle>
        Flujo
    </x-slot>

    <x-slot:headerFiles>
        <!--  ESTILOS PERSONALIZADOS  -->
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <!-- Menú de navegación vertical -->
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" 
                                data-bs-target="#v-pills-home" type="button" role="tab" 
                                aria-controls="v-pills-home" aria-selected="true">
                            Reporte administrativo
                        </button>

                        <button class="nav-link" id="v-pills-report-tab" data-bs-toggle="pill" 
                                data-bs-target="#v-pills-report" type="button" role="tab" 
                                aria-controls="v-pills-report" aria-selected="false">
                            Reporte de flujo
                        </button>
                    </div>

                    <!-- Contenido de las pestañas (IMPORTANTE: UN SOLO "tab-content") -->
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Pestaña: Reporte administrativo -->
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" 
                             aria-labelledby="v-pills-home-tab">
                            @include("f_flux_reports.adminReport")
                        </div>

                        <!-- Pestaña: Reporte de flujo -->
                        <div class="tab-pane fade" id="v-pills-report" role="tabpanel" 
                             aria-labelledby="v-pills-report-tab">
                            @include("f_flux_reports.fluxReport")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footerFiles>
        <!-- Bootstrap JS (necesario para el correcto funcionamiento de las pestañas) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </x-slot>
</x-base-layout>
