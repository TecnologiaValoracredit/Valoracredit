<form id="supplier_form" action="{{ route('suppliers.store') }}">
    <div>Agregar proveedor</div>
    <div class="row">
        <div class="col-md-6 mt-2">
            @include("components.custom.forms.input", [
                "id" => "name",
                "name" => "name",
                "type" => "text",
                "placeholder" => "Nombre...",
                "label" => "Nombre",
                "required" => false,
                "value" => old("name"),
            ])
        </div>
        <div class="col-md-6 mt-2">
            @include("components.custom.forms.input", [
                "id" => "description",
                "name" => "description",
                "type" => "text",
                "placeholder" => "Descripción...",
                "label" => "Descripción",
                "required" => false,
                "value" => old("description"),
            ])
        </div>
        <div class="col-md-12 mt-2 d-flex justify-content-center mt-2">
            @include("components.custom.forms.input-check", [
                "id" => "is_active",
                "name" => "is_active",
                "checked" => true,
                "label" => "Activo",
            ])
        </div>
    </div>
</form>