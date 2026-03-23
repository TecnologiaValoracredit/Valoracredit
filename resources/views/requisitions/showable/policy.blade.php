<div class="mb-2">
    <div class="mb-2 mt-2">POLIZA</div>

    <div class="d-flex justify-content-center">
        @if (isset($requisition->policy->path))
            <div>
                <a href="{{ route('files.showRequisitionFile', [$requisition->id, $requisition->policy->path]) }}" target="_blank" class="link link-primary">Ver mas</a>
            </div>
        @else
        <div class="mb-2"><b>Poliza no cargada</b></div>
        @endif
    </div>
</div>