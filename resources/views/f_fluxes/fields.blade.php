<!-- Fecha-->
<div class="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "accredit_date",
        "name" => "accredit_date",
        "type" => "date",
        "label" => "Fecha acreditado",
        "required" => true,
        "value" => isset($f_flux) ? $f_flux->accredit_date :  old("accredit_date"),
        "invalid_feedback" => "El campo es requerido",
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
        "invalid_feedback" => "El campo es requerido",
    ])
</div>

<!-- ID de cuenta-->
<div class= "mb-2">
    @include("components.custom.forms.input-inline-select", [
        "id" => "f_account_id",
        "name" => "f_account_id",
        "elements" => $f_accounts,
        "placeholder" => "Cuenta",
        "value" => isset($f_flux) ? $f_flux->f_account_id : old("f_account_id"),
        "label" => "Cuenta",
        "required" => true,
        "invalid_feedback" => "El campo es requerido",
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
        "invalid_feedback" => "El campo es requerido",
    ])
</div>
<!-- Monto-->
<div class ="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "amount",
        "name" => "amount",
        "type" => "number",
        "placedolder" => "Monto",
        "value" => isset($f_flux) ? $f_flux->amount :old("amount"),
        "label" => "Monto",
        "required" => true,
        "invalid_feedback" => "El campo es requerido",
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
        "invalid_feedback" => "El campo es requerido",

    ])
</div>    
<!-- Tipo de gasto-->
<div class= "mb-2">
    @include("components.custom.forms.input-inline-select", [
        "id" => "f_expense_type_id",
        "name" => "f_expense_type_id",
        "elements" => $f_expense_types,
        "placeholder" => "Tipo de gasto",
        "value" => isset($f_flux) ? $f_flux->f_expense_type_id : old("f_expense_type_id"),
        "label" => "Tipo de gasto",
        "required" => true,
        "invalid_feedback" => "El campo es requerido",

    ])
</div> 
<div class= "mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "f_clasification_name",
        "name" => "f_clasification_name",
        "placeholder" => "Clasificación admin.",
        "type" => "autocomplete",
        "value" => isset($f_flux) ? $f_flux->fClasification->name ?? "" : old("f_clasification_name"),
        "input_hidden" => "f_clasification_id",
        "value_hidden" => isset($f_flux) ? $f_flux->f_clasification_id : old("f_clasification_id"),
        "label" => "Clasificación admin.",
        "invalid_feedback" => "El campo es requerido",

    ])
</div>
<div class= "mb-2">
    @include("components.custom.forms.input-inline-select", [
        "id" => "f_cob_clasification_id",
        "name" => "f_cob_clasification_id",
        "elements" => $f_cob_clasifications,
        "placeholder" => "Clasificación cartera",
        "value" => isset($f_flux) ? $f_flux->f_cob_clasification_id : old("f_cob_clasification_id"),
        "label" => "Clasificación cartera",
        "invalid_feedback" => "El campo es requerido",

    ])
</div>  
<!-- Cuenta-->
<div class="mb-2">
    @include("components.custom.forms.input-inline",[
        "id" => "notes1",
        "name" => "notes1",
        "type" => "text",
        "placedolder" => "Notas admin.",
        "value" => isset($f_flux) ? $f_flux->notes1 : old("notes1"),
        "label" => "Notas admin.",
        "invalid_feedback" => "El campo es requerido",
    ])
</div>
<!-- Cuenta 2-->
<div class="mb-2">
    @include("components.custom.forms.input-inline",[
        "id" => "notes2",
        "name" => "notes2",
        "type" => "text",
        "placedolder" => "Notas cartera",
        "value" => isset($f_flux) ? $f_flux->notes2 : old("notes2"),
        "label" => "Notas cartera",
        "invalid_feedback" => "El campo es requerido",

    ])
</div>
<!-- Comentarios-->
<div class="mb-2">
    @include("components.custom.forms.input-inline",[
        "id" => "comments",
        "name" => "comments",
        "type" => "text",
        "placedolder" => "Comentarios",
        "value" => isset($f_flux) ? $f_flux->comments : old("comments"),
        "label" => "Comentarios",
        "invalid_feedback" => "El campo es requerido",

    ])
</div>

<!--Activo-->
<div class="mb-2 d-none">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($f_flux) ? $f_flux->is_active :  true,
        "label" => "Activo",
    ])
</div>
