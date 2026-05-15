<div class="text-center text-dark mb-2"><b>TOTAL:</b> &dollar;{{{ number_format($total, 2) ?? "TOTAL" }}}</div>
<div class="requisitions-container d-flex align-items-center overflow-auto gap-3 min-w-0">
    @foreach ($requisitions as $requisition)
    <div class="card requisition-card flex-shrink-0 pb-2" data-id="{{ $requisition->id }}" data-folio="{{ $requisition->folio }}" data-amount="{{ $requisition->amount }}" data-notes="{{ $requisition->notes }}">
        <div class="d-flex justify-content-center p-3 bg-gradient bg-primary">
            <div class="fw-bolder">
                <a href="{{ route('requisitions.show', $requisition->id) }}" class="link-light" target="_blank"
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Ver más">
                    {{ $requisition->folio }}
                </a>
            </div>
        </div>
        <div class="collapsable">
            <div class="d-flex justify-content-between px-3 py-2 gap-3 overflow-auto">
                <div class="fw-bolder">
                    Proveedor
                </div>
                <div>
                    {{ $requisition->supplier->name }}
                </div>
            </div>
            <div class="d-flex justify-content-between px-3 py-2 gap-3 overflow-auto">
                <div class="fw-bolder">
                    Solicita
                </div>
                <div data-bs-toggle="tooltip" data-bs-placement="right" title="{{ $requisition->user->name }}">
                    {{ $requisition->user->getFirstTwoNames() }}
                </div>
            </div>
            <div class="d-flex flex-column px-3 py-2">
                <div class="fw-bolder">
                    Notas
                </div>
                <div>
                    {{ $requisition->notes }}
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
                        <div class="d-flex justify-content-between px-3 py-2 gap-3 overflow-auto">
                            <div class="fw-bolder">
                                Costo Unitario
                            </div>
                            <div>
                                &dollar;{{ number_format($row->product_cost, 2) }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between px-3 py-2 gap-3 overflow-auto">
                            <div class="fw-bolder">
                                Cantidad
                            </div>
                            <div>
                                {{ $row->product_quantity }}
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
                    <a href="{{ route('files.showRequisitionFile', [$requisition->id, $requisition->policy->path]) }}" target="_blank" class="link link-primary policy-link">Ver póliza</a>
                </div>
            </div>
            <div class="d-flex justify-content-between px-3 py-2">
                <div class="fw-bolder">
                    Subtotal
                </div>
                <div>
                    &dollar;{{ number_format($requisition->getSubtotal(), 2) }}
                </div>
            </div>
            <div class="d-flex justify-content-between px-3 py-2">
                <div class="fw-bolder">
                    Total IVA
                </div>
                <div>
                    &dollar;{{ number_format($requisition->getTotalIva(), 2) }}
                </div>
            </div>
            @foreach ($requisition->currenciesWithTotals() as $currency => $total)
            <div class="d-flex justify-content-between px-3 py-2">
                <div class="fw-bolder">
                    {{ "Total ({$currency})" }}
                </div>
                <div>
                    &dollar;{{ number_format($total, 2) }}
                </div>
            </div>
            @endforeach
            <hr>
            @switch($currentActions)
                @case('admin-account')
                    @include('requisition_globals.cards.admin-account-actions')
                    @break
                @case('dg')
                    @include('requisition_globals.cards.dg-actions')
                    @break
                @case('treasury')
                    @include('requisition_globals.cards.treasury-actions')
                    @break
                @case('info')
                    @include('requisition_globals.cards.decisions_status')
                    @break
                @default
            @endswitch
        </div>
    </div>
    @endforeach
</div>