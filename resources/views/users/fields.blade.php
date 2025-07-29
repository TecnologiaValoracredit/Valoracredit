<div class="row mb-2">
    <div class="col-8">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "label" => "Nombre",
            "required" => true,
            "value" => isset($user) ? $user->name :  old("name"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-4">
        @include("components.custom.forms.input-select", [
            "id" => "role_id",
            "name" => "role_id",
            "elements" => $roles,
            "placeholder" => "Descripción...",
            "value" => isset($user) ? $user->role_id :  old("role_id"),
            "label" => "Rol",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "email",
        "name" => "email",
        "type" => "email",
        "placeholder" => "Email...",
        "value" => isset($user) ? $user->email :  old("email"),
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
<div class="row mb-2">
    <div class="col">
        @include("components.custom.forms.input-select", [
            "id" => "departament_id",
            "name" => "departament_id",
            "elements" => $departaments,
            "placeholder" => "Descripción...",
            "value" => isset($user) ? $user->departament_id :  old("departament_id"),
            "label" => "Departamento",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col">
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
</div>
<div class="row mb-2">
    <div class="col">
        @include("components.custom.forms.input", [
            "id" => "bank_account",
            "name" => "bank_account",
            "type" => "numeric",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Cuenta bancaria",
            "value" => isset($user) ? $user->bank_account :  old("bank_account"),
        ])
    </div>
</div>





<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($user) ? $user->is_active :  true,
        "label" => "Activo",
    ])
</div>


