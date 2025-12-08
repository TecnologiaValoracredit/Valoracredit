<div class="mb-1">
    DATOS DOMICILIARIOS
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "residential_address",
        "name" => "residential_address",
        "type" => "text",
        "placeholder" => "Calle y numero...",
        "value" => isset($user) ? $user->residential_address :  old("residential_address"),
        "label" => "Domicilio",
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "colony",
        "name" => "colony",
        "type" => "text",
        "placeholder" => "Colonia...",
        "value" => isset($user) ? $user->colony :  old("colony"),
        "label" => "Colonia",
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "municipality",
        "name" => "municipality",
        "type" => "text",
        "placeholder" => "Municipio...",
        "value" => isset($user) ? $user->municipality :  old("municipality"),
        "label" => "Municipio",
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "postal_code",
        "name" => "postal_code",
        "type" => "number",
        "placeholder" => "Codigo postal...",
        "value" => isset($user) ? $user->postal_code :  old("postal_code"),
        "label" => "Codigo Postal",
    ])
</div>