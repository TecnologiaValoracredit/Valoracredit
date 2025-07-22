<div class="row mb-2">
    <div class="col">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "label" => "Nombre",
            "required" => true,
            "value" => isset($s_branch) ? $s_branch->name :  old("name"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
  
</div>

<div class="row">
     <div class="col">
        @include("components.custom.forms.input", [
            "id" => "segment",
            "name" => "segment",
            "type" => "text",
            "placeholder" => "Segmento...",
            "label" => "Segmento",
            "required" => true,
            "value" => isset($s_branch) ? $s_branch->segment :  old("segment"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="mb-2 col">
        @include("components.custom.forms.input", [
            "id" => "accounting_account",
            "name" => "accounting_account",
            "type" => "text",
            "placeholder" => "Cuenta contable...",
            "value" => isset($s_branch) ? $s_branch->accounting_account :  old("accounting_account"),
            "label" => "Cuenta contable",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>


<div class="row">
    <div class="col my-3">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => isset($s_branch) ? $s_branch->is_active :  true,
            "label" => "Activo",
        ])
    </div>
</div>
