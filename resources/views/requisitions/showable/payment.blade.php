<div class="mb-2">
    <div class="mb-2 mt-2">COMPROBANTE DE PAGO</div>

    <div class="d-flex justify-content-center">
        @if (isset($requisition->payment->path))
            <div>
                <a href="{{ route('files.showRequisitionFile', [$requisition->id, $requisition->payment->path]) }}" target="_blank" class="link link-primary">Ver mas</a>
            </div>
        @else
        <div class="mb-2"><b>Comprobante no subido</b></div>
        @endif
    </div>
</div>