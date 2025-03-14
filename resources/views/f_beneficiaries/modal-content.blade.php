<input type="hidden" id="type" value="{{$type}}">
<div class="mb-2">
    @include("components.custom.forms.input", [
        "id" => "name",
        "name" => "name",
        "type" => "text",
        "placeholder" => "Nombre...",
        "label" => "Nombre de beneficiario",
        "required" => true,
        "value" => isset($f_beneficiary) ? $f_beneficiary->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div>
<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($f_beneficiary) ? $f_beneficiary->is_active :  true,
        "label" => "Activo",
    ])
</div>
