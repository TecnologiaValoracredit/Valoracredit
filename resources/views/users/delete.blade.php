<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Dar de baja a empleado
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
                <h5 class="card-title">Baja de empleado</h5>
                <form id="user_form" class="row g-3 needs-validation" novalidate method="POST"  enctype="multipart/form-data" action="{{ route('users.destroy', $user->id)  }}" >
                    @csrf
                    @method("DELETE")
                    @include("users.deleteFields")
                </form>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>