<div class="row mt-2">
    <div class="col-md-4 d-flex flex-column">
        <input type="hidden" name="user_id" value="{{ isset($user) ? $user->id : '' }}">
        <div>
            <label for="user"><strong>Solicitante:</strong></label>
            <span id="user">{{ isset($requisition) ? $requisition->user->name : $user->name }}</span>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-center">
        <input type="hidden" name="department_id" value="{{ isset($user) ? $user->departament->id : '' }}">
        <div>
            <label for="departament"><strong>Departamento:</strong></label>
            <span id="departament">{{ isset($requisition) ? $requisition->departament->name : $user->departament->name }}</span>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-center">
        <input type="hidden" name="branch_id" value="{{ isset($user) ? $user->branch->id : '' }}">
        <div>
            <label for="branch"><strong>Sucursal:</strong></label>
            <span id="branch">{{ isset($requisition) ? $requisition->user->branch->name : $user->branch->name }}</span>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-4 d-flex align-items-center">
        <div>
            <label for="request_date"><strong>Fecha de solicitud:</strong></label>
            <span id="request_date">{{ isset($requisition) ? $requisition->request_date : now() }}</span>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "payment_type_id",
            "name" => "payment_type_id",
            "elements" => $payment_types,
            "placeholder" => "Tipo de pago...",
            "value" => isset($requisition->payment_type_id) ? $requisition->payment_type_id :  old("payment_type_id"),
            "label" => "Tipo de pago",
            "readonly" => isset($readonly) ? $readonly : false,
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-8">
        @include("components.custom.forms.textarea",[
            "id" => "notes",
            "name" => "notes",
            "type" => "textarea",
            "placedolder" => "Notas de requisición",
            "value" => isset($requisition) ? $requisition->notes : old("notes"),
            "label" => "Notas de requisición",
            "readonly" => isset($readonly) ? $readonly : '',
            "required" => false,
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>
</div>
<div class="row mt-3 mb-2 m-0">
    <div class="col d-flex justify-content-end">
        <div>
            <label for="amount" class="text-decoration-underline"><strong>Costo Total:</strong></label>
            <span id="amount">0.00</span>
        </div>
    </div>
</div>