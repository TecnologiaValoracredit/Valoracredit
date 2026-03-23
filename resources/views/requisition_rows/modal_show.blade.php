<div class="modal-header bg-light">
    <h5 class="modal-title" id="modal-title">Evidencias de producto</h5>
    <button id="close_btn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
    </button>
</div>

<div class="modal-body bg-light">
    @include("components.custom.errors")

    <div class="p-3 bg-light rounded shadow-sm">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="w-100 h-100">
                @include('requisition_rows.show')
            </div>
        </div>
    </div>
</div>

<div class="modal-footer bg-light">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
</div>

@vite('resources/js/requisitions/show.js')