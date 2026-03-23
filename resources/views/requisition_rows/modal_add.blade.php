<div class="modal-header bg-light">
    <h5 class="modal-title" id="modal-title">Añadir producto</h5>
    <button id="close_btn" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
    </button>
</div>

<div class="modal-body bg-light">
    @include("components.custom.errors")

    <div class="p-3 bg-light rounded shadow-sm">
        @csrf
        <div class="d-flex justify-content-center">
            <div class="w-100">
                @include("requisition_rows.fields")
            </div>
        </div>
    </div>
</div>

<div class="modal-footer bg-light">
    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
    <button type="submit" id="modal-action-btn" form="product_form" class="btn btn-primary">
        Guardar
    </button>
</div>

@vite('resources/js/requisitions/main.js')