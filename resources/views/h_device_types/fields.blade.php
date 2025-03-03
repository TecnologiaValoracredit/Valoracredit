<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "text",
        "placeholder" => "Nombre...",
        "label" => "Nombre",
        "required" => true,
        "value" => isset($h_device_type) ? $h_device_type->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "description",
        "name" => "description",
        "type" => "text",
        "placeholder" => "Descripción...",
        "label" => "Descripción",
        "required" => false,
        "value" => isset($h_device_type) ? $h_device_type->description :  old("description"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<!-- Activo -->
<div class="mb-2">
  @include("components.custom.forms.input-check", [
    "id" => "is_active",
    "name" => "is_active",
    "checked" => isset($h_hardware) ? $h_hardware->is_active : true,
    "label" => "Activo",
  ])
</div>