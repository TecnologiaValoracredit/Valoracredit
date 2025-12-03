<div class="mb-1">
    CONTRATOS
</div>

<div class="col-6">
    @include("components.custom.forms.input-inline-select", [
        "id" => "contract_id",
        "name" => "contract_id",
        "elements" => $contracts,
        "placeholder" => "Selecciona el contrato...",
        "value" => old("contract_id"),
        "label" => "Contrato",
    ])

</div>
<div class="col-6">
    <a id="btnGenerateContract" class="btn btn-primary">
        Generar contrato
    </a>
</div>

<div class="col-12">
    <div id="contracts-table">
        @include("users.contracts-table")
    </div>
</div>
