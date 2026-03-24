<div class="requisitions-container d-flex align-items-center overflow-auto gap-3 min-w-0">
    @foreach ($requisitions as $requisition)
    <div class="card requisition-card flex-shrink-0" data-folio="{{ $requisition->folio }}" data-amount="{{ $requisition->amount }}">
        <div class="d-flex justify-content-center p-3 bg-gradient bg-primary">
            <div class="fw-bolder">
                <a href="{{ route('requisitions.show', $requisition->id) }}" class="link-light" target="_blank"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Ver más">
                    {{ $requisition->folio }}
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-between p-3">
            <div class="fw-bolder">
                Proveedor
            </div>
            <div>
                {{ $requisition->supplier->name }}
            </div>
        </div>
        <div class="d-flex justify-content-between p-3">
            <div class="fw-bolder">
                Solicita
            </div>
            <div data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $requisition->user->name }}">
                {{ $requisition->user->getFirstName() }}
            </div>
        </div>
        
        <!--CONTENEDOR DE PRODUCTOS DE REQUISICIÓN-->
        <div class="p-3">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-center">
                    <div class="fw-bold">Productos</div>
                </div>
                <hr>

                @foreach ($requisition->requisitionRows as $row)
                    <div class="d-flex justify-content-between p-3">
                        <div class="fw-bolder">
                            Concepto
                        </div>
                        <div>
                            {{ $row->product }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between p-3">
                        <div class="fw-bolder">
                            Descripción
                        </div>
                        <div>
                            {{ $row->product_description }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between p-3">
                        <div class="fw-bolder">
                            Costo
                        </div>
                        <div>
                            &dollar;{{ number_format($row->product_cost, 2) }}
                        </div>
                    </div>
                    <div id="see-products-container" class="d-flex justify-content-center">
                        <a onclick="requestEvidences({{ $row }}, this)" class="link-primary" type="button" data-bs-toggle="modal" data-bs-target="#reg-modal">
                            Ver productos
                        </a>
                        <input type="hidden" name="currency_type_id" value="{{ $row->currencyType->name }}">
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-between p-3">
            <div class="fw-bolder">
                Total
            </div>
            <div data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $requisition->user->name }}">
                &dollar;{{ number_format($requisition->amount, 2) }}
            </div>
        </div>

        @if(Route::currentRouteName() == 'requisition_globals.changeStatus')
            @if ($requisition->roleReturnedApproval('Contabilidad') || $requisition->roleReturnedApproval('Administración'))
                <div class="d-flex justify-content-center align-item-center">
                    <span class="badge badge-danger">Devuelta</span>
                </div>
            @elseif($requisition->roleApprovedApproval('Contabilidad') && $requisition->roleApprovedApproval('Administración') || $requisition->adminSignatureApproval())
                <div class="d-flex justify-content-center align-item-center">
                    <span class="badge badge-success">Aprobada</span>
                </div>
            @else
                <div class="text-center fw-bolder p-3">
                    Aprobar
                </div>
                <div class="d-flex justify-content-center align-items-center p-3">
                    @include("components.custom.forms.input-check", [
                        "id" => "req-{$requisition->id}",
                        "name" => "req-{$requisition->id}",
                        "checked" => true,
                        "label" => "",
                    ])
                </div>
                <div class="collapse">
                    <div class="p-3">
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
        @else
            <div class="d-flex justify-content-between p-3">
                <div class="fw-bolder">
                    Decisión de D.G.
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    @if ($requisition->latestRoleApproval('Dirección general'))
                        @switch($requisition->latestRoleApproval('Dirección general')->decision)
                            @case("Aprobada")
                                <span class="badge badge-success">Aprobada</span>
                                @break
                                
                            @case("Rechazada")
                                <span class="badge badge-danger">Rechazada</span>
                                @break
                            @case("Devuelta")
                                <span class="badge badge-danger">Devuelta</span>
                                @break
                            @default
                                
                        @endswitch
                    @else
                        <div>
                            Aun no revisada
                        </div>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-between p-3">
                <div class="fw-bolder">
                    Decisión de Administración
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    @if ($requisition->adminSignatureApproval())
                        <span class="badge badge-success">Aprobada</span>
                    @elseif ($requisition->latestRoleApproval('Administración'))
                        @switch($requisition->latestRoleApproval('Administración')->decision)
                            @case("Aprobada")
                                <span class="badge badge-success">Aprobada</span>
                                @break
                                
                            @case("Rechazada")
                                <span class="badge badge-danger">Rechazada</span>
                                @break
                            @case("Devuelta")
                                <span class="badge badge-danger">Devuelta</span>
                                @break
                            @default
                                
                        @endswitch
                    @else
                        <div>
                            Aun no revisada
                        </div>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-between p-3">
                <div class="fw-bolder">
                    Decisión de Contabilidad
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    @if($requisition->adminSignatureApproval())
                        <span class="badge badge-success">Aprobada</span>
                    @elseif ($requisition->latestRoleApproval('Contabilidad'))
                        @switch($requisition->latestRoleApproval('Contabilidad')->decision)
                            @case("Aprobada")
                                <span class="badge badge-success">Aprobada</span>
                                @break
                                
                            @case("Rechazada")
                                <span class="badge badge-danger">Rechazada</span>
                                @break
                            @case("Devuelta")
                                <span class="badge badge-danger">Devuelta</span>
                                @break
                            @default
                                
                        @endswitch
                    @else
                        <div>
                            Aun no revisada
                        </div>
                    @endif
                </div>
            </div>
        @endif


        @if($requisition_global->requisitionGlobalStatus->name == 'Revisada'  && ($isSendingToReview || $isSendingToDg))
            <div class="d-flex justify-content-center">
                <div class="fw-bold">Cuenta</div>
            </div>
            <div class="p-3">
                @include("components.custom.forms.input-select", [
                    "id" => "req-{$requisition->id}-bank_id",
                    "name" => "req-{$requisition->id}-bank_id",
                    "elements" => $banks,
                    "placeholder" => "Selecciona la cuenta...",
                    "value" => old("req{$requisition->id}-bank_id"),
                    "label" => "",
                    'required' => true,
                    "invalid_feedback" => "El campo es requerido",
                ])
            </div>
        @endif
    </div>
    @endforeach
</div>