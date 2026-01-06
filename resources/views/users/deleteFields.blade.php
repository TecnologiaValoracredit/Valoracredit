<div class="row mb-2">
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "termination_reason_id",
            "name" => "termination_reason_id",
            "elements" => $terminationReasons,
            "placeholder" => "Selecciona la razón de baja...",
            "value" => old("termination_reason_id"),
            "label" => "Razón de baja",
            "required" => true,
            ])
    </div>
    
    <div class="col-md-4">
        @include("components.custom.forms.input", [
            "id" => "termination_date",
            "name" => "termination_date",
            "type" => "date",
            "placeholder" => "Fecha de baja...",
            "value" => old("entry_date"),
            "label" => "Fecha de baja",
            "required" => true,
            ])
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
            @include("components.custom.forms.textarea", [
                "id" => "termination_description",
                "name" => "termination_description",
                "type" => "textarea",
                "placeholder" => "Descripción de baja...",
                "label" => "Descripción de baja",
                "value" => old("Descripción de baja"),
                "required" => true,
                "invalid_feedback" => "El campo es requerido",
            ])
    </div>
</div>