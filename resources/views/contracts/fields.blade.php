<div class="row mb-2 mt-1 gy-3">
    <div class="mb-1">
        DATOS DE CONTRATO
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "label" => "Nombre",
            "required" => true,
            "value" => isset($contract) ? $contract->name :  old("name"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    
    <div class="col-6">
        @include("components.custom.forms.input-select", [
            "id" => "contract_type_id",
            "name" => "contract_type_id",
            "elements" => $types,
            "placeholder" => "Tipo...",
            "value" => isset($contract) ? $contract->contract_type_id :  old("contract_type_id"),
            "label" => "Tipo",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-12">
        <label for="contract_content" class="form-label">Contenido</label>
        <textarea name="content" 
        class="form-control" 
        rows="20" 
        id="contract_content"
        wrap="hard">{{ isset($contract) ? $contract->content : old('content') }}
        </textarea>
    </div>
</div>