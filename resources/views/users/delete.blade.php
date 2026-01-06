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
                    <div class="d-flex flex-column justify-content-center">
                        <div class="w-100">
                            @include("users.deleteFields")
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('users.index')}}" class="btn btn-dark">Cancelar</a>
                                <button type="submit" class="btn btn-danger">Dar de baja</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>