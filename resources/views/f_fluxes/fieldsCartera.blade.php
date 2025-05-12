<style>
    div {
        font-size: 16px;
        color:rgb(52, 52, 52);
    }
</style>
<div class="mb-2">
    <strong>Fecha acreditado:</strong> {{ isset($f_flux) ? date("d/m/Y", strtotime($f_flux->accredit_date)) : '-' }}
</div>

<!-- Beneficiario -->
<div class="mb-2">
    <strong>Beneficiario:</strong> {{ isset($f_flux) ? $f_flux->fBeneficiary->name : '-' }}
</div>

<!-- ID de cuenta -->
<div class="mb-2">
    <strong>Cuenta:</strong> 
    {{ $f_flux ? $f_flux->fAccount->name : '-' }}
</div>

<!-- Concepto -->
<div class="mb-2">
    <strong>Concepto:</strong> {{ isset($f_flux) ? $f_flux->concept : '-' }}
</div>

<div class="mb-2">
    <strong>Tipo movimeinto:</strong> {{ isset($f_flux) ? $f_flux->fMovementType->name : '-' }}
</div>

<!-- Monto -->
<div class="mb-2">
    <strong>Monto:</strong> ${{ isset($f_flux) ? number_format($f_flux->amount, 2) : '-' }}
</div>

<div class="mb-2">
    <strong>Clasificación administración:</strong> {{ isset($f_flux) ? $f_flux->fClasification->name ?? 'Sin clasificar' : '-' }}
</div>

<div class="mb-2">
    <strong>Notas administración:</strong> {{ isset($f_flux) ? $f_flux->fClasification->notes1 ?? '' : '-' }}
</div>
<hr>
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

<div class="mb-2">
    @include("components.custom.forms.input-inline",[
        "id" => "notes2",
        "name" => "notes2",
        "type" => "text",
        "placedolder" => "Notas cartera",
        "value" => isset($f_flux) ? $f_flux->notes2 :old("notes2"),
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
        "value" => isset($f_flux) ? $f_flux->comments :old("comments"),
        "label" => "Comentarios",
        "invalid_feedback" => "El campo es requerido",

    ])
</div>