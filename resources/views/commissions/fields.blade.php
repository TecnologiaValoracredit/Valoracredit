<div class="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "name",
        "name" => "name",
        "type" => "string",
        "label" => "Nombre",
        "required" => true,
        "value" => isset($s_coordinator) ? $s_coordinator->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])

<div class="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "previous_name",
        "name" => "previous_name",
        "type" => "string",
        "label" => "Nombre anterior",
        "required" => true,
        "value" => isset($s_coordinator) ? $s_coordinator->previous_name :  old("previous_name"),
        "invalid_feedback" => "El campo es requerido"
    ])


<!--Activo-->
<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($s_coordinator) ? $s_coordinator->is_active :  true,
        "label" => "Activo",
    ])
  </div>
