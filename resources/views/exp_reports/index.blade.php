<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="exp_reports">
    <x-slot:pageTitle>
        Reporte de expedientes 
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <!-- CONTENT HERE -->
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        @include("exp_reports.tables.general")
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-9">
                        @include("exp_reports.tables.no_cedidos")
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-9">
                        @include("exp_reports.tables.fimubac")
                    </div>
                </div>
                <hr>
                @include("exp_reports.tables.por_dependencia")

            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>