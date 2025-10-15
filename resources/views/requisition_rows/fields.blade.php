<div class="row mt-2">
    <input type="hidden" name="requisition_id" value="{{ isset($requisition) ? $requisition->id : '' }}">
    <input type="hidden" id="requisition_row_id" name="requisition_row_id" value="{{isset($requisitionRow) ? $requisitionRow->id : null}}">

    <div class="col-12 col-md-6 mt-2">
        @include("components.custom.forms.input", [
            "id" => "prduct",
            "name" => "product",
            "type" => "text",
            "placeholder" => "Producto...",
            "label" => "Producto",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "value" => isset($requisitionRow) ? $requisitionRow->product :  old("product"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-12 col-md-6 mt-2">
        @include("components.custom.forms.input-select", [
            "id" => "supplier_id",
            "name" => "supplier_id",
            "elements" => $suppliers,
            "placeholder" => "Selecciona al proveedor...",
            "value" => isset($requisitionRow) ? $requisitionRow->supplier_id :  old("suppliers_id"),
            "label" => "Proveedor",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    
@if (isset($readonly))
    <div class="col-12 col-md-6 mt-2">
        <label for="Evidencia" class="form-label">Evidencia</label>
        <a href="{{route("requisition_rows.downloadFile", $requisitionRow->id)}}" class="btn btn-outline-primary">
            Descargar
        </a>
    </div>
@else
    <div class="col-12 col-md-6 mt-2">
        @include("components.custom.forms.input", [
            "id" => "evidence",
            "name" => "evidence",
            "type" => "file",
            "placeholder" => "Archivo...",
            "label" => "Evidencia",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "value" => isset($requisitionRow) ? $requisitionRow->evidence :  old("evidence"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
@endif


    <div class="col-12 col-md-6 mt-2">
        @include("components.custom.forms.input", [
            "id" => "link",
            "name" => "link",
            "type" => "url",
            "placeholder" => "Url...",
            "label" => "Sitio web",
            "readonly" => isset($readonly) ? $readonly : false,
            "value" => isset($requisitionRow) ? $requisitionRow->link :  old("link"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-12 col-md-6 mt-2">
        @include("components.custom.forms.input", [
            "id" => "product_quantity",
            "name" => "product_quantity",
            "type" => "numeric",
            "placeholder" => "Cantidad de producto...",
            "label" => "Cantidad",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "value" => isset($requisitionRow) ? $requisitionRow->product_quantity :  old("product_quantity"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-12 col-md-4 mt-2">
        @include("components.custom.forms.input", [
            "id" => "product_cost",
            "name" => "product_cost",
            "type" => "numeric",
            "placeholder" => "Costo del producto...",
            "label" => "Costo Unitario",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "value" => isset($requisitionRow) ? $requisitionRow->product_cost :  old("product_cost"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-12 col-md-2 mt-2 pt-4">
        @include("components.custom.forms.input-check", [
            "id" => "has_iva",
            "name" => "has_iva",
            "checked" => isset($requisitionRow) ? $requisitionRow->has_iva :  true,
            "label" => "¿Incluye IVA?",
        ])
    </div>
     <div class="col-12 col-md-6 mt-2">
        @include("components.custom.forms.input-select", [
            "id" => "currency_type_id",
            "name" => "currency_type_id",
            "elements" => $currency_types,
            "placeholder" => "Selecciona el tipo de moneda...",
            "value" => isset($requisitionRow) ? $requisitionRow->currency_type_id :  old("suppliers_id"),
            "label" => "Tipo de moneda",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-12 col-md-6 mt-2">
        @include("components.custom.forms.input", [
            "id" => "total_cost",
            "name" => "total_cost",
            "type" => "nuemric",
            "placeholder" => "Costo total...",
            "label" => "Total",
            "required" => true,
            "readonly" => true,
            "value" => isset($requisitionRow) ? $requisitionRow->total_cost :  old("total_cost"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="row">
        <div class="col-12 col-md-6 mt-2">
            @include("components.custom.forms.textarea", [
                "id" => "product_description",
                "name" => "product_description",
                "type" => "textarea",
                "placeholder" => "Descripción...",
                "label" => "Descripción",
                "required" => true,
                "readonly" => isset($readonly) ? $readonly : false,
                "value" => isset($requisitionRow) ? $requisitionRow->product_description :  old("product_description"),
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>

        <div class="col-12 col-md-6 mt-2">
            @include("components.custom.forms.textarea", [
                "id" => "reason",
                "name" => "reason",
                "type" => "textarea",
                "placeholder" => "Razón de selección...",
                "label" => "Razón",
                "required" => true,
                "readonly" => isset($readonly) ? $readonly : false,
                "value" => isset($requisitionRow) ? $requisitionRow->reason :  old("reason"),
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    </div>
</div>

@vite(['resources/js/requisitions/generals.js'])