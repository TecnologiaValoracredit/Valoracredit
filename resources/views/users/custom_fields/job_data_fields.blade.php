<div class="mb-1">
    DATOS LABORALES
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "employee_number",
        "name" => "employee_number",
        "type" => "number",
        "placeholder" => "Numero de empleado...",
        "value" => isset($user) ? $user->employee_number :  old("employee_number"),
        "label" => "Numero de empleado",
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input-select", [
        "id" => "branch_id",
        "name" => "branch_id",
        "elements" => $branches,
        "placeholder" => "Descripción...",
        "value" => isset($user) ? $user->branch_id :  old("branch_id"),
        "label" => "Sucursal",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "entry_date",
        "name" => "entry_date",
        "type" => "date",
        "placeholder" => "Fecha de entrada...",
        "value" => isset($user) ? $user->entry_date :  old("entry_date"),
        "label" => "Fecha de entrada",
    ])
</div>

<div class="col-4">
@include("components.custom.forms.input-select", [
    "id" => "departament_id",
    "name" => "departament_id",
    "elements" => $departaments,
    "placeholder" => "Departamento...",
    "value" => isset($user) ? $user->departament_id :  old("departament_id"),
    "label" => "Departamento",
    "required" => true,
    "invalid_feedback" => "El campo es requerido"
])
</div>

<div class="col-4">
    @include("components.custom.forms.input-select", [
        "id" => "position_id",
        "name" => "position_id",
        "elements" => $job_positions,
        "placeholder" => "Puesto de trabajo...",
        "value" => isset($user) ? $user->position_id :  old("position_id"),
        "label" => "Puesto de trabajo",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input-select", [
        "id" => "boss_id",
        "name" => "boss_id",
        "elements" => $users,
        "placeholder" => "Puesto de trabajo...",
        "value" => isset($user) ? $user->boss_id :  old("boss_id"),
        "label" => "Jefe directo",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "salary",
        "name" => "salary",
        "type" => "number",
        "placeholder" => "Salario...",
        "label" => "Salario",
        "value" => isset($user) ? $user->salary :  old("salary"),
    ])
</div>

<div class="col-8">
    @include("components.custom.forms.input", [
        "id" => "other_benefits",
        "name" => "other_benefits",
        "type" => "text",
        "placeholder" => "Otras prestaciones...",
        "label" => "Otras prestaciones",
        "value" => isset($user) ? $user->other_benefits :  old("other_benefits"),
    ])
</div>