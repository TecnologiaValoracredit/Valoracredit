<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "text",
        "placeholder" => "Nombre...",
        "label" => "Nombre",
        "required" => true,
        "value" => isset($branch) ? $branch->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>




<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($branch) ? $branch->is_active :  true,
        "label" => "Activo",
    ])
</div>
