<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "text",
        "placeholder" => "Nombre...",
        "label" => "Nombre",
        "required" => true,
        "value" => isset($supplier) ? $supplier->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "description",
        "name" => "description",
        "type" => "text",
        "placeholder" => "Descripción...",
        "value" => isset($supplier) ? $supplier->description :  old("description"),
        "label" => "Descripción",
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($supplier) ? $supplier->is_active :  true,
        "label" => "Activo",
    ])
</div>
