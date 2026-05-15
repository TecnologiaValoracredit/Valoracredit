<div class="d-flex justify-content-center">
    <div class="fw-bold">Cuenta</div>
</div>
<div class="px-3 py-2">
    @include("components.custom.forms.input-select", [
        "id" => "req-{$requisition->id}-bank_id",
        "name" => "req-{$requisition->id}-bank_id",
        "elements" => $banks,
        "placeholder" => "Selecciona la cuenta...",
        "value" => isset($requisition->bank_id) ? $requisition->bank_id :  old("req{$requisition->id}-bank_id"),
        "label" => "",
        'required' => true,
        "invalid_feedback" => "El campo es requerido",
    ])
</div>