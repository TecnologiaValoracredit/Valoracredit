<div class="row mb-4 d-flex flex-column align-items-center justify-content-center gap-2">
    <div class="col-md-5">
        <canvas id="canvas" class="border border-white rounded" style="width: 100%;"></canvas>

        <div class="text-center">
            <label for="canvas"><strong>Firma</strong></label>
        </div>
        <input type="hidden" id="signature_data" name="signature_data">
    </div>

    <div class="col-md-1">
        <div id="clear_signature" class="btn btn-danger">Borrar</div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-center">            
        @include("components.custom.forms.input-check", [
            "id" => "save_signature",
            "name" => "save_signature",
            "checked" => true,
            "label" => "Guardar Firma",
        ])
    </div>
</div>