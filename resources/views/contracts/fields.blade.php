<div class="row mb-2 mt-1 gy-3">
    <div class="mb-1">
        @if (isset($contract))
        <div class="d-flex justify-content-between">
                <p>DATOS DE CONTRATO</p>
                <a target="_blank" href="{{route('contracts.exportContract', [$contract->id, null])}}" class="d-block btn btn-secondary">Ver contrato PDF</a>
            </div>
        @endif
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

    <hr>
    <!-- Variables disponibles -->
    <h3>Variables disponibles</h3>
    <p>Clic para copiar en el contenido</p>

    <div class="col-12">
        @foreach ($variables as $variable)
            <span  class="btn m-1 variable-copy"
                data-value="{{ $variable->key_detection }}">
                {{ $variable->name }} - {{ $variable->key_detection }}
            </span>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        <div style="width: 816px">
            <label for="contract_content" class="form-label">Contenido</label>
            <textarea name="content" 
            class="tinymce form-control" 
            rows="20" 
            id="contract_content"
            wrap="hard">{{ isset($contract) ? $contract->content : old('content') }}</textarea>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => isset($user) ? $user->is_active :  true,
            "label" => "Activo",
        ])
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const textarea = document.getElementById("contract_content");

    document.querySelectorAll(".variable-copy").forEach(btn => {
        btn.addEventListener("click", () => {
            const text = btn.dataset.value;

            // Copiar al portapapeles
            navigator.clipboard.writeText(text);

            // Insertar automáticamente en el textarea
            tinymce.activeEditor.execCommand('mceInsertContent', false, text + " ");
        });
    });
});
</script>
