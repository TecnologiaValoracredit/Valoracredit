<div class="row">
    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "label" => "Nombre",
            "required" => true,
            "value" => isset($expenseType) ? $expenseType->name :  old("name"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    
    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "description",
            "name" => "description",
            "type" => "text",
            "placeholder" => "Descripción...",
            "value" => isset($expenseType) ? $expenseType->description :  old("description"),
            "label" => "Descripción",
        ])
    </div>
    
    <div class="mb-2 mt-2 d-flex justify-content-center ">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => isset($expenseType) ? $expenseType->is_active :  true,
            "label" => "Activo",
        ])
    </div>
</div>
