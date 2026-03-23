<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Detalle de Requisición
    </x-slot>

    <input type="hidden" id="requisition_id" value="{{$requisition->id}}">

    <x-slot:headerFiles>
        
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detalle de Requisición</h5>

                <ul class="nav nav-tabs" id="navbar" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="requisition-tab" data-bs-toggle="tab" data-bs-target="#requisition-pane" type="button" role="tab">
                            DETALLES
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="flux-tab" data-bs-toggle="tab" data-bs-target="#flux-pane" type="button" role="tab">
                            FLUJO
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policy-pane" type="button" role="tab">
                            POLIZA
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="approvals-tab" data-bs-toggle="tab" data-bs-target="#approvals-pane" type="button" role="tab">
                            DECISIONES
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment-pane" type="button" role="tab">
                            PAGO
                        </button>
                    </li>
                </ul>

                <div class="tab-content mb-2">
                      <div class="tab-pane fade show active" id="requisition-pane" role="tabpanel" aria-labelledby="requisition-tab">
                        <div class="row mt-2">
                            @include('requisitions.showable.fields')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="flux-pane" role="tabpanel" aria-labelledby="flux-tab">
                        <div class="row mt-2">
                            @include('requisitions.showable.logs')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="policy-pane" role="tabpanel" aria-labelledby="policy-pane">
                        <div class="row mt-2">
                            @include('requisitions.showable.policy')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="approvals-pane" role="tabpanel" aria-labelledby="approvals-pane">
                        <div class="row mt-2">
                            @include('requisitions.showable.approvals')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="payment-pane" role="tabpanel" aria-labelledby="payment-pane">
                        <div class="row mt-2">
                            @include('requisitions.showable.payment')
                        </div>
                    </div>
                </div>

                @if ($isAbleToSendAndDelete)
                    <div class="row mb-2">
                        <div class="col-md-12 d-flex justify-content-center gap-4">
                            <button id="send_requisition_btn" class="btn btn-primary w-15"
                                onclick="sendRequisition({{ $requisition->id }})">Enviar a revisión
                            </button>
                                
                            <button id="delete_requisition_btn" class="btn btn-danger w-15"
                            onclick="deleteRequisition({{ $requisition->id }})">Eliminar</button>
                        </div>
                    </div>

                @elseif($isAbleToSendAndCancel)
                    <div class="row mb-2">
                        <div class="col-md-12 d-flex justify-content-center gap-4">
                            <button id="send_requisition_btn" class="btn btn-primary w-15"
                                onclick="sendRequisition({{ $requisition->id }})">Enviar a revisión
                            </button>
                                
                            <button id="cancel_requisition_btn" class="btn btn-danger w-15"
                            onclick="cancelRequisition({{ $requisition->id }})">Cancelar</button>
                        </div>
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
