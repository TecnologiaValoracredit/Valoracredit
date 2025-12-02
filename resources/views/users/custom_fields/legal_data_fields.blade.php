<div class="mb-1">
    DATOS LEGALES
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "curp",
        "name" => "curp",
        "type" => "text",
        "placeholder" => "CURP...",
        "label" => "Clave Unica de Registro de Población",
        "required" => true,
        "value" => isset($user) ? $user->curp :  old("curp"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "rfc",
        "name" => "rfc",
        "type" => "text",
        "placeholder" => "RFC...",
        "label" => "Registro Federal de Contribuyentes",
        "required" => true,
        "value" => isset($user) ? $user->rfc :  old("rfc"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "nss",
        "name" => "nss",
        "type" => "text",
        "placeholder" => "NSS...",
        "label" => "Numero de Seguro Social",
        "required" => true,
        "value" => isset($user) ? $user->nss :  old("nss"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="col-4">
        @include("components.custom.forms.input-select", [
        "id" => "gender_id",
        "name" => "gender_id",
        "elements" => $genders,
        "placeholder" => "Selecciona el genero...",
        "value" => isset($user) ? $user->gender_id :  old("gender_id"),
        "label" => "Genero",
    ])
</div>

<div class="col-4">
        @include("components.custom.forms.input-select", [
        "id" => "civil_status_id",
        "name" => "civil_status_id",
        "elements" => $civilStatuses,
        "placeholder" => "Selecciona el estado civil...",
        "value" => isset($user) ? $user->civil_status_id :  old("civil_status_id"),
        "label" => "Estado civil",
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "birthday",
        "name" => "birthday",
        "type" => "date",
        "placeholder" => "Fecha de nacimiento...",
        "value" => isset($user) ? $user->birthday :  old("birthday"),
        "label" => "Fecha de nacimiento",
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "birthplace",
        "name" => "birthplace",
        "type" => "text",
        "placeholder" => "Lugar de nacimiento...",
        "value" => isset($user) ? $user->birthplace :  old("birthplace"),
        "label" => "Lugar de nacimiento",
    ])
</div>