<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Detalle de Requisición Global
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
                }
            }
        </style>
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detalle de Requisición Global</h5>         
                <form id="form" class="row mb-2 mt-2 needs-validation" novalidate method="POST" action="{{ route('requisition_globals.send', $requisition_global->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex flex-column justify-content-center">
                        <div class="w-100">
                            @if ($isEmpty)
                                <div class="mt-3 text-center"><b>Para visualizar correctamente una global, esta debe contener requisiciones</b></div>
                            @else
                                @include('requisition_globals.showable.fields')
                            @endif
                        </div>
                    </div>
                </form>

                @if ($isSendingToReview || $isSendingToDg && !$isEmpty)
                    <div class="col-md-12 d-flex justify-content-center gap-4">
                        <button type="submit" form="form" id="send_requisition_btn" class="btn btn-primary w-15">
                            {{ $isSendingToDg ? "Enviar a Dirección general" : "Enviar a Revisión (Administración y Contabilidad)" }}
                        </button>
                    </div>
                @endif
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
        
    </x-slot>

</x-base-layout>