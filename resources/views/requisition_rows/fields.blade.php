<form id="product_form" method="POST" enctype="multipart/form-data">
    @csrf
    <div>Datos generales</div>
    <div class="row mt-2 mb-3">
        <div class="col-md-4 mt-2 ">
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
            @include("components.custom.forms.input", [
                "id" => "product_quantity",
                "name" => "product_quantity",
                "type" => "number",
                "min" => "1",
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
                "min" => "1",
                "step" => "0.01",
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
        <div id="percentage_container" class="col-md-4 mt-2 d-none">
            @include("components.custom.forms.input", [
                "id" => "iva_percentage",
                "name" => "iva_percentage",
                "type" => "number",
                "min" => "1",
                "placeholder" => "Porcentaje de IVA...",
                "label" => "Porcentaje de IVA",
                "required" => false,
                "readonly" => false,
                "value" => 1,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
        <div class="col-md-4 mt-2">
            @include("components.custom.forms.input-select", [
                "id" => "expense_duration_id",
                "name" => "expense_duration_id",
                "elements" => $expense_durations,
                "placeholder" => "Selecciona el tipo de periodo...",
                "value" => isset($requisitionRow) ? $requisitionRow->expense_type_id :  old("expense_duration_id"),
                "label" => "Tipo de periodo",
                "invalid_feedback" => "El campo es requerido"
                ])
        </div>
        <div class="col-md-4 mt-2">
            @include("components.custom.forms.input", [
                "id" => "starting_date",
                "name" => "starting_date",
                "type" => "date",
                "placeholder" => "Fecha de entrada...",
                "value" => isset($requisitionRow) ? $requisitionRow->starting_date :  old("starting_date"),
                "label" => "Fecha de inicio",
            ])
        </div>
    </div>

    <div class="row mb-2 d-flex justify-content-center align-items-center">
        <div class="col-md-4 mt-2 d-flex justify-content-center align-items-center">
            @include("components.custom.forms.input-check", [
                "id" => "has_iva",
                "name" => "has_iva",
                "checked" => true,
                "label" => "¿Precio unitario incluye IVA?",
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
    
    <div>Evidencia/Soporte</div>
    <div class="row">
        <div id="evidence_files_container" class="col-md-12 mb-3 d-flex align-items-center gap-3 p-3 border-left border-right overflow-auto min-w-0"></div>
    </div>
    <div class="row mb-2">
        <p id="evidence_message"></p>
        <div class="col-12 col-md-6 mt-2">
            <label for="evidence" class="form-label">Captura de pantalla</label>
            <b class="text-danger">*</b>
            <input name="evidence" type="file" class="form-control"
                id="evidence" value="{{ old("evidence") }}" placeholder="Archivo..."
                accept="image/*,.pdf" required multiple>
        </div>
    
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
                "readonly" => isset($readonly) ? $readonly : false,
                "value" => isset($requisitionRow) ? $requisitionRow->reason :  old("reason"),
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    </div>
</form>