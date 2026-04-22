<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Cambiar Estatús de Requisición Global
    </x-slot>

    <x-slot:headerFiles>
        <style>
            .requisition-card,
            .suppliers-card{
                width: 35%;
                height: 600px;

                overflow-y: auto;
            }

            @media (max-width: 768px) {
                .requisition-card,
                .suppliers-card{
                    width: 100%;
                    height: auto;
                }

                .requisitions-container{
                    flex-direction: column;
                }
            }
        </style>
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cambiar Estatús de Requisición Global</h5>
                
                <form id="form" class="row g-3 needs-validation" novalidate method="POST" enctype="multipart/form-data" action="{{ route('requisition_globals.updateStatus', $requisition_global->id)  }}" >
                    @csrf
                    @method("PUT")
                    <div class="d-flex flex-column justify-content-center">
                        <div class="w-100">
                            @include('requisition_globals.showable.fields')

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('requisition_globals.index')}}" class="btn btn-dark">Regresar</a>
                                <button id="submit_btn" type="submit" class="btn btn-primary">Aprobar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reg-modal" aria-labelledby="modal-title" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                @include('requisition_rows.modal_show')
            </div>
        </div>
    </div>
    <x-slot:footerFiles>
        @vite('resources/js/requisition_globals/changeStatus.js')
        @vite('resources/js/requisition_globals/show.js')
    </x-slot>

</x-base-layout>