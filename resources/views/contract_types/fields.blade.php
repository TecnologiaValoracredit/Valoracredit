    <div class="mb-3">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "label" => "Nombre",
            "required" => true,
            "value" => isset($contractType) ? $contractType->name :  old("name"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="mb-3">
        @include("components.custom.forms.input", [
            "id" => "description",
            "name" => "description",
            "type" => "text",
            "placeholder" => "Descripción...",
            "value" => isset($contractType) ? $contractType->description :  old("description"),
            "label" => "Descripción",
        ])
    </div>

    <div class="mb-2">
        @include("components.custom.forms.input-check", [
            "id" => "is_indeterminate",
            "name" => "is_indeterminate",
            "checked" => false,
            "label" => "Indeterminado",
        ])
    </div>

    <div class="mb-4" id="duration-container">
        @include("components.custom.forms.input", [
            "id" => "duration",
            "name" => "duration",
            "type" => "number",
            "placeholder" => "Duración...",
            "label" => "Duración",
            "required" => true,
            "value" => isset($contractType) ? $contractType->duration :  old("plastic_number"),
        ])
    </div>

    <div class="mb-3">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => isset($contractType) ? $contractType->is_active :  true,
            "label" => "Activo",
        ])
    </div>

    @if (isset($contractType) && $contractType->duration == -1)
    <script>
        document.addEventListener('DOMContentLoaded', () =>{
            window.markCheckbox();
        })

    </script>
    @endif