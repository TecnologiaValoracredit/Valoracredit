<div>Datos generales</div>
<div class="row mt-2">
    <div class="col-md-4 mt-2">
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
    <div class="col-md-4 mt-2">
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
    <div class="col-md-4 mt-2">
        @include("components.custom.forms.input", [
            "id" => "product_quantity",
            "name" => "product_quantity",
            "type" => "number",
            "placeholder" => "Cantidad de producto...",
            "label" => "Cantidad",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "value" => isset($requisitionRow) ? $requisitionRow->product_quantity :  old("product_quantity"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-4 mt-2">
        @include("components.custom.forms.input", [
            "id" => "product_cost",
            "name" => "product_cost",
            "type" => "number",
            "placeholder" => "Costo del producto...",
            "label" => "Precio Unitario",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "value" => isset($requisitionRow) ? $requisitionRow->product_cost :  old("product_cost"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-4 mt-2">
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
    <div class="col-md-4 mt-2 d-flex align-items-center">
        @include("components.custom.forms.input-check", [
            "id" => "has_iva",
            "name" => "has_iva",
            "checked" => isset($requisitionRow) ? $requisitionRow->has_iva :  true,
            "label" => "¿Incluye IVA?",
        ])
    </div>
</div>

<div class="row mb-2">
    <div class="col d-flex justify-content-end">
        <div>
            <label for="total_cost" class="text-decoration-underline"><strong>Costo Total:</strong></label>
            <span id="visible_total">$0.00</span>
            <input type="hidden" name="total_cost" id="total_cost" value="0">
        </div>
    </div>
</div>

<hr class="border border-dark">

<div>Evidencia</div>
<div class="row mb-2">
        @if (isset($readonly))
            <div class="col-12 col-md-6 mt-2">
                <label for="Evidencia" class="form-label">Evidencia</label>
                <a href="{{route("requisition_rows.downloadFile", $requisitionRow->id)}}" class="btn btn-outline-primary">
                    Descargar
                </a>
            </div>
        @else
            <div class="col-12 col-md-6 mt-2">
                <label for="evidence" class="form-label">Captura de pantalla</label>
                <b class="text-danger">*</b>
                <input name="evidence" type="file" class="form-control"
                 id="evidence" value="{{ old("evidence") }}" placeholder="Archivo..."
                  accept="image/*" required multiple>
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
</div>

<hr class="border border-dark">

<div class="row mb-2">
    <div class="col-md-12 mt-2">
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

    <div class="col-md-12 mt-2">
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