<div class="row mb-2">
    <div class="col-md-4">
        @include("components.custom.forms.input", [
            "id" => "entry_hour",
            "name" => "entry_hour",
            "type" => "datetime-local",
            "placeholder" => "Hora de entrada",
            "value" => isset($permit) ? $permit->entry_hour :  old("entry_hour"),
            "label" => "Hora de entrada",
            "readonly" => isset($permit) && $permit->permitStatus->name != "Creado" ? true : false,
            "required" => true,
            ])
    </div>
    
    <div class="col-md-4">
        @include("components.custom.forms.input", [
            "id" => "exit_hour",
            "name" => "exit_hour",
            "type" => "datetime-local",
            "placeholder" => "Hora de salida",
            "value" => isset($permit) ? $permit->exit_hour :  old("exit_hour"),
            "label" => "Hora de salida",
            "readonly" => isset($permit) && $permit->permitStatus->name != "Creado" ? true : false,
            "required" => true,
            ])
    </div>

</div>

<div class="row mb-2">
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "motive_id",
            "name" => "motive_id",
            "elements" => $motives,
            "placeholder" => "Selecciona el motivo...",
            "value" => isset($permit) ? $permit->motive_id :  old("motive_id"),
            "label" => "Motivo",
            "readonly" => isset($permit) && $permit->permitStatus->name != "Creado" ? true : false,
            "required" => true,
            ])
    </div>
    
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "discount_characteristic_id",
            "name" => "discount_characteristic_id",
            "elements" => $discount_characteristics,
            "placeholder" => "Selecciona la característica del descuento...",
            "value" => isset($permit) ? $permit->discount_characteristic_id :  old("discount_characteristic_id"),
            "label" => "Característica del descuento",
            "readonly" => isset($permit) && $permit->permitStatus->name != "Creado" ? true : false,
            "required" => true,
            ])
    </div>

</div>

<div class="row mb-4">
    <div class="col-md-12">
            @include("components.custom.forms.textarea", [
                "id" => "user_observations",
                "name" => "user_observations",
                "type" => "textarea",
                "placeholder" => "Observaciones...",
                "label" => "Observaciones",
                "value" => isset($permit) ? $permit->user_observations :  old("user_observations"),
                "invalid_feedback" => "El campo es requerido"
            ])
    </div>
</div>

@if (!isset($permit) && !auth()->user()->path_signature)
    <div class="row mb-4 d-flex flex-column align-items-center justify-content-center">
        <div class="col-md-3">
            <canvas id="canvas" class="border border-white rounded" style="width:100%;"></canvas>
            <div class="text-center">
                <label for="canvas"><strong>Firma</strong></label>
            </div>
            <input type="hidden" id="signature_data" name="signature_data">
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
@endif
