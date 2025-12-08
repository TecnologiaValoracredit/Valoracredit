<div class="mb-1">
    CONTRATOS
</div>

<div class="col-5">
    @include("components.custom.forms.input-inline-select", [
        "id" => "contract_id",
        "name" => "contract_id",
        "elements" => $contracts,
        "placeholder" => "Selecciona el contrato...",
        "value" => old("contract_id"),
        "label" => "Contrato",
    ])

</div>
<div class="col-4">
        @include("components.custom.forms.input-inline", [
            "id" => "initial_date",
            "name" => "initial_date",
            "type" => "date",
            "label" => "Inicio de contrato",
            // "required" => true,
            "value" => old("initial_date"),
            "invalid_feedback" => "El campo es requerido",
            'dataTab' => 'contracts'
        ])
    </div>
<div class="col-3">
    <a id="btnGenerateContract" class="btn btn-primary">
        Generar contrato
    </a>
</div>

<div class="col-12">
    <div id="contracts-table">
        @include("users.contracts-table")
    </div>
</div>
