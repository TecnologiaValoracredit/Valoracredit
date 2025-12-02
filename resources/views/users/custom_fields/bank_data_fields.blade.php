
<div class="mb-1">
    DATOS BANCARIOS
</div>

<div class="col-12">
        @include("components.custom.forms.input-select", [
        "id" => "bank_id",
        "name" => "bank_id",
        "elements" => $banks,
        "placeholder" => "Selecciona el banco...",
        "value" => isset($user) ? $user->bank_id :  old("bank_id"),
        "label" => "Banco",
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "bank_account",
        "name" => "bank_account",
        "type" => "number",
        "placeholder" => "Cuenta bancaria...",
        "label" => "Cuenta bancaria",
        "value" => isset($user) ? $user->bank_account :  old("bank_account"),
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "interbank_code",
        "name" => "interbank_code",
        "type" => "number",
        "placeholder" => "Clabe interbancaria...",
        "label" => "Clabe interbancaria",
        "value" => isset($user) ? $user->interbank_code :  old("interbank_code"),
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input", [
        "id" => "plastic_number",
        "name" => "plastic_number",
        "type" => "number",
        "placeholder" => "Numero de plastico...",
        "label" => "Numero de plastico",
        "value" => isset($user) ? $user->plastic_number :  old("plastic_number"),
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "infonavit_credit_number",
        "name" => "infonavit_credit_number",
        "type" => "number",
        "placeholder" => "Numero de credito Infonavit...",
        "label" => "Numero de credito infonavit",
        "value" => isset($user) ? $user->infonavit_credit_number :  old("infonavit_credit_number"),
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "discount_factor",
        "name" => "discount_factor",
        "type" => "number",
        "placeholder" => "Factor descuento...",
        "label" => "Factor descuento",
        "value" => isset($user) ? $user->discount_factor :  old("discount_factor"),
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "fonacot_credit_number",
        "name" => "fonacot_credit_number",
        "type" => "number",
        "placeholder" => "Numero de credito Fonacot...",
        "label" => "Numero de credito Fonacot",
        "value" => isset($user) ? $user->fonacot_credit_number :  old("fonacot_credit_number"),
    ])
</div>

<div class="col-6">
    @include("components.custom.forms.input", [
        "id" => "food_pension",
        "name" => "food_pension",
        "type" => "number",
        "placeholder" => "Pensión alimenticia...",
        "label" => "Pensión alimenticia",
        "value" => isset($user) ? $user->food_pension :  old("food_pension"),
    ])
</div>