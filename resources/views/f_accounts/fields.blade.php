<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "text",
        "placeholder" => "Nombre...",
        "label" => "Nombre de cuenta",
        "required" => true,
        "value" => isset($f_account) ? $f_account->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "account_number",
        "name" => "account_number",
        "type" => "text",
        "placeholder" => "Número de cuenta...",
        "value" => isset($f_account) ? $f_account->account_number :  old("account_number"),
        "label" => "Número de cuenta",
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "balance",
        "name" => "balance",
        "type" => "number",
        "value" => isset($f_account) ? $f_account->balance :  old("balance"),
        "label" => "Saldo",
    ])
</div>

<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($f_account) ? $f_account->is_active :  true,
        "label" => "Activo",
    ])
</div>
