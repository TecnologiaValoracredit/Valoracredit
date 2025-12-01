
<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "text",
        "placeholder" => "Nombre...",
        "label" => "Nombre",
        "required" => true,
        "value" => isset($job_position) ? $job_position->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input-select", [
        "id" => "departament_id",
        "name" => "departament_id",
        "elements" => $departaments,
        "placeholder" => "Departamento...",
        "value" => isset($job_position) ? $job_position->departament_id :  old("departament_id"),
        "label" => "Departamento",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "description",
        "name" => "description",
        "type" => "text",
        "placeholder" => "Descripción...",
        "value" => isset($job_position) ? $job_position->description :  old("description"),
        "label" => "Descripción",
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($job_position) ? $job_position->is_active :  true,
        "label" => "Activo",
    ])
</div>