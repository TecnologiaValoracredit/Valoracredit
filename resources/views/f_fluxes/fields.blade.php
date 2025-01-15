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


<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($f_flux) ? $f_flux->is_active :  true,
        "label" => "Activo",
    ])
</div>
