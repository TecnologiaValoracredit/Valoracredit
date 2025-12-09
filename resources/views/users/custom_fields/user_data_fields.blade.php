<div class="mb-1">
    DATOS DE USUARIO
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "text",
        "placeholder" => "Nombre...",
        "label" => "Nombre",
        "required" => true,
        "value" => isset($user) ? $user->name :  old("name"),
        "invalid_feedback" => "El campo es requerido",
        "dataTab" => "user",
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "email",
        "name" => "email",
        "type" => "email",
        "placeholder" => "Email...",
        "value" => isset($user) ? $user->email :  old("email"),
        "label" => "Email",
        "required" => true,
        "invalid_feedback" => "El campo es requerido",
        "dataTab" => "user",
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input-select", [
        "id" => "role_id",
        "name" => "role_id",
        "elements" => $roles,
        "placeholder" => "Descripción...",
        "value" => isset($user) ? $user->role_id :  old("role_id"),
        "label" => "Rol",
        "required" => true,
        "invalid_feedback" => "El campo es requerido",
        "dataTab" => "user",
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "password",
        "name" => "password",
        "type" => "password",
        "placeholder" => "Contraseña...",
        "value" => session("old_password"),
        "label" => "Contraseña",
        "dataTab" => "user",
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "phone",
        "name" => "phone",
        "type" => "number",
        "placeholder" => "Telefono...",
        "value" => isset($user) ? $user->phone :  old("phone"),
        "label" => "Telefono",
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "emergency_phone",
        "name" => "emergency_phone",
        "type" => "number",
        "placeholder" => "Telefono...",
        "value" => isset($user) ? $user->emergency_phone :  old("emergency_phone"),
        "label" => "Telefono de emergencia",
    ])
</div>

<div class="d-flex justify-content-center">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($user) ? $user->is_active :  true,
        "label" => "Activo",
    ])
</div>