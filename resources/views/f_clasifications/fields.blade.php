<div class="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "name",
        "name" => "name",
        "type" => "string",
        "label" => "Nombre",
        "required" => true,
        "value" => isset($f_clasification) ? $f_clasification->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])

    <!--Activo-->
<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($f_flux) ? $f_flux->is_active :  true,
        "label" => "Activo",
    ])
</div>
