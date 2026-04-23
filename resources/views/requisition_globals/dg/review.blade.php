<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Solicitúd de autorización para pagos
    </x-slot>

    <input type="hidden" id="requisition_global_id" value="{{$requisition_global->id}}">

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
                <h5 class="card-title">Solicitúd de autorización para pagos</h5>         
                <form id="form" class="row mb-2 mt-2 d-flex justify-content-center" method="POST" action="{{ route('requisition_globals.approve', $requisition_global->id) }}">
                    @csrf
                    @method("PUT")                    
                    <div class="w-100">
                        @include('requisition_globals.showable.dg.fields')
                    </div>
                </form>

                <div class="col-md-12 d-flex justify-content-center">
                    <button form="form" type="submit" class="btn btn-info">
                        Finalizar
                    </button>
                </div>
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
        @vite('resources/js/requisition_globals/review.js')
        @vite('resources/js/requisition_globals/show.js')
    </x-slot>

</x-base-layout>