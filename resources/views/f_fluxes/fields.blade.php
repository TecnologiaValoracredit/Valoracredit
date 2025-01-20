<!-- Fecha-->
<div class="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "accredit_date",
        "name" => "accredit_date",
        "type" => "date",
        "label" => "Fecha acreditado",
        "required" => true,
        "value" => isset($f_flux) ? $f_flux->accredit_date :  old("accredit_date"),
        "invalid_feedback" => "El campo es requerido"
    ])
    <!-- Beneficiario-->
</div>
<div class="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "f_beneficiary_name",
        "name" => "f_beneficiary_name",
        "type" => "autocomplete",
        "label" => "Beneficiario",
        "required" => true,
        "value" => isset($f_flux) ? $f_flux->fBeneficiary->name :  old("f_beneficiary_name"),
        "input_hidden" => "f_beneficiary_id",
        "value_hidden" => isset($f_flux) ? $f_flux->f_beneficiary_id :  old("f_beneficiary_id"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<!-- ID de cuenta-->
<div class= "mb-2">
    @include("components.custom.forms.input-inline-select", [
        "id" => "f_account_id",
        "name" => "f_account_id",
        "elements" => $f_accounts,
        "placeholder" => "Id de cuenta",
        "value" => isset($f_flux) ? $f_flux->f_account_id : old("f_account_id"),
        "label" => "Id de cuenta",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>    

<!-- Concepto-->
<div class="mb-2">
    @include("components.custom.forms.input-inline",[
        "id" => "concept",
        "name" => "concept",
        "type" => "text",
        "placedolder" => "Concepto",
        "value" => isset($f_flux) ? $f_flux->concept :old("concept"),
        "label" => "Concepto",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>
<!-- Monto-->
<div class ="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "amount",
        "name" => "amount",
        "type" => "float",
        "placedolder" => "Monto",
        "value" => isset($f_flux) ? $f_flux->amount :old("amount"),
        "label" => "Monto",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>
<!-- Tipo de movimiento-->
<div class= "mb-2">
    @include("components.custom.forms.input-inline-select", [
        "id" => "f_movement_type_id",
        "name" => "f_movement_type_id",
        "elements" => $f_movement_types,
        "placeholder" => "Tipo de movimiento",
        "value" => isset($f_flux) ? $f_flux->f_movement_type_id : old("f_movement_type_id"),
        "label" => "Tipo de movimiento",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
</div>    
<!-- Cuenta-->
<div class="mb-2">
    @include("components.custom.forms.input-inline",[
        "id" => "account",
        "name" => "account",
        "type" => "text",
        "placedolder" => "Cuenta 1",
        "value" => isset($f_flux) ? $f_flux->account :old("account"),
        "label" => "Cuenta 1",
        "invalid_feedback" => "El campo es requerido"
    ])
</div>
<!-- Cuenta 2-->
<div class="mb-2">
    @include("components.custom.forms.input-inline",[
        "id" => "account2",
        "name" => "account2",
        "type" => "text",
        "placedolder" => "Cuenta 2",
        "value" => isset($f_flux) ? $f_flux->account :old("account2"),
        "label" => "Cuenta 2",
        "invalid_feedback" => "El campo es requerido"
    ])
</div>
<!-- Comentarios-->
<div class="mb-2">
    @include("components.custom.forms.input-inline",[
        "id" => "comments",
        "name" => "comments",
        "type" => "text",
        "placedolder" => "Comentarios",
        "value" => isset($f_flux) ? $f_flux->comments :old("comments"),
        "label" => "Comentarios",
        "invalid_feedback" => "El campo es requerido"
    ])
</div>

<!--Activo-->
<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($f_flux) ? $f_flux->is_active :  true,
        "label" => "Activo",
    ])
</div>
