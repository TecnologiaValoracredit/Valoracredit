<div class="requisitions-container d-flex align-items-center gap-3 overflow-auto min-w-0">
    @foreach ($requisitions as $requisition)
    <div class="card requisition-card flex-shrink-0 mb-10 rounded-2" data-folio="{{ $requisition->folio }}" data-amount="{{ $requisition->amount }}">
        <div class="d-flex justify-content-center p-3 bg-gradient bg-primary">
            <div class="fw-bolder">
                <a href="{{ route('requisitions.show', $requisition->id) }}" class="link-light" target="_blank"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Ver más">
                    {{ $requisition->folio }}
                </a>
            </div>
        </div>
        <div class="collapsable">
            <div class="d-flex justify-content-between px-3 py-2">
                <div class="fw-bolder">
                    Proveedor
                </div>
                <div>
                    {{ $requisition->supplier->name }}
                </div>
            </div>
            <div class="d-flex justify-content-between px-3 py-2">
                <div class="fw-bolder">
                    Solicita
                </div>
                <div data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $requisition->user->name }}">
                    {{ $requisition->user->getFirstTwoNames() }}
                </div>
            </div>
            
            <!--CONTENEDOR DE PRODUCTOS DE REQUISICIÓN-->
            <div class="px-3 py-2">
                <div class="d-flex flex-column">
                    <div class="d-flex justify-content-center">
                        <div class="fw-bold">Productos</div>
                    </div>
                    <hr>
                    @foreach ($requisition->requisitionRows as $row)
                        <div class="d-flex flex-column px-3 py-2">
                            <div class="fw-bolder">
                                Concepto
                            </div>
                            <div>
                                {{ $row->product }}
                            </div>
                        </div>
                        <div class="d-flex flex-column px-3 py-2">
                            <div class="fw-bolder">
                                Descripción
                            </div>
                            <div>
                                {{ $row->product_description }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between px-3 py-2">
                            <div class="fw-bolder">
                                Costo
                            </div>
                            <div>
                                &dollar;{{ number_format($row->product_cost, 2) }}
                            </div>
                        </div>
                        <div id="see-products-container" class="d-flex justify-content-center">
                            <a onclick="requestEvidences({{ $row }}, this)" class="link-primary" type="button" data-bs-toggle="modal" data-bs-target="#reg-modal">
                                Ver producto
                            </a>
                            <input type="hidden" name="currency_type_id" value="{{ $row->currencyType->name }}">
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <div class="text-align-center">
                    <a href="{{ route('files.showRequisitionFile', [$requisition->id, $requisition->policy->path]) }}" target="_blank" class="link link-primary">Ver póliza</a>
                </div>
            </div>
            <div class="d-flex justify-content-between px-3 py-2">
                <div class="fw-bolder">
                    Cuenta
                </div>
                <div data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $requisition->user->name }}">
                    {{ $requisition->bank->name }}
                </div>
            </div>
            <div class="d-flex justify-content-between px-3 py-2">
                <div class="fw-bolder">
                    Total
                </div>
                <div data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $requisition->user->name }}">
                    &dollar;{{ number_format($requisition->amount, 2) }}
                </div>
            </div>
            @if ($requisition->roleApprovedApproval("Dirección general"))
                <div class="text-center px-3 py-2">
                    <strong>{{ $requisition->lastApproval->decision }}</strong>
                </div>
            @else
                <div class="d-flex justify-content-center">
                    <div class="fw-bold">Decisión</div>
                </div>
                <div class="d-flex justify-content-center px-3 py-2">
                    <div class="toggle-btn btn btn-primary w-50">
                        Alternar
                    </div>
                </div>
                <div class="px-3 py-1 mb-3>
                    @include("components.custom.forms.input-select", [
                        "id" => "req-{$requisition->id}-decision",
                        "name" => "req-{$requisition->id}-decision",
                        "elements" => ['Aprobada' => 'Aprobar', 'Devuelta' => 'Devolver', 'Rechazada' => 'Rechazar'],
                        "placeholder" => "Decision...",
                        "value" => 'Aprobada',
                        "label" => "",
                        "invalid_feedback" => "El campo es requerido",
                    ])
                </div>
                <div class="notes-collapsable collapse">
                    <div class="px-3 py-2">
                        @include("components.custom.forms.input", [
                        "id" => "req-{$requisition->id}-notes",
                        "name" => "req-{$requisition->id}-notes",
                        "type" => "text",
                        "placeholder" => "Notas...",
                        "label" => "",
                        "value" => old("req-{$requisition->id}-decision"),
                        "invalid_feedback" => "El campo es requerido",
                    ])
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>