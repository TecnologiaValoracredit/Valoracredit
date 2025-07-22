<div class="row mb-2">
    <div class="col">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "label" => "Nombre",
            "required" => true,
            "value" => isset($s_coordinator) ? $s_coordinator->user->name :  old("name"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    {{-- <div class="col-4">
        @include("components.custom.forms.input-select", [
            "id" => "role_id",
            "name" => "role_id",
            "elements" => $roles,
            "placeholder" => "Descripción...",
            "value" => isset($s_coordinator) ? $s_coordinator->user->role_id :  old("role_id"),
            "label" => "Rol",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div> --}}
</div>

@if (!$isEdit)
<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "email",
        "name" => "email",
        "type" => "email",
        "placeholder" => "Email...",
        "value" => isset($s_coordinator) ? $s_coordinator->user->email :  old("email"),
        "label" => "Email",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>


<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "password",
        "name" => "password",
        "type" => "password",
        "placeholder" => "Contraseña...",
        "label" => "Contraseña",
    ])
</div>
@endif

<div class="row mb-2">
    <div class="col">
        @include("components.custom.forms.input-select", [
            "id" => "branch_id",
            "name" => "branch_id",
            "elements" => $branches,
            "placeholder" => "Descripción...",
            "value" => isset($s_coordinator) ? $s_coordinator->user->branch_id :  old("branch_id"),
            "label" => "Sucursal",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col">
        @include("components.custom.forms.input-select", [
            "id" => "s_branch_id",
            "name" => "s_branch_id",
            "elements" => $s_branches,
            "placeholder" => "Descripción...",
            "value" => isset($s_coordinator) ? $s_coordinator->s_branch_id :  old("s_branch_id"),
            "label" => "Sucursal en CrediSoft",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>


<div class="row mb-3">
    <div class="col">
        @include("components.custom.forms.input", [
            "id" => "commission_percentage",
            "name" => "commission_percentage",
            "type" => "numeric",
            "placeholder" => "Porcentaje de comisión...",
            "label" => "Porcentaje de comisión",
            "required" => true,
            "value" => isset($s_coordinator) ? $s_coordinator->commission_percentage :  old("commission_percentage"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col p-3 d-flex align-items-center justify-content-center">
        @include("components.custom.forms.input-check", [
        "id" => "is_broker",
        "name" => "is_broker",
        "checked" => isset($s_coordinator) ? $s_coordinator->is_broker :  false,
        "label" => "Es broker",
    ])
    </div>

    <div class="col my-2">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => isset($s_coordinator) ? $s_coordinator->is_active :  true,
            "label" => "Activo",
        ])
    </div>
</div>
