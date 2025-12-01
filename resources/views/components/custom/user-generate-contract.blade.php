@php
    if (!isset($user)) return;
@endphp

@include('components.custom.forms.input-select', [
    "id" => "contract_id",
    "name" => "contract_id",
    "elements" => $ $contracts,
    "placeholder" => "Selecciona el tipo de contrato a generar",
    "value" => old("contract_id"),
    "label" => "Tipo de contrato",
]);