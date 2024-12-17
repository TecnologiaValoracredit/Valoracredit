<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="expedients">
    <x-slot:pageTitle>
        Expedientes 
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
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Expedientes</h5>
                    @if($allowAdd)
                        <!-- <form class="row g-3 needs-validation" novalidate method="POST" action="" enctype="multipart/form-data">
                            @csrf
                           
                        </form> -->
                    @endif
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/expedients.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>