<div class="row mt-2">
    <div class="col">
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        @include("components.custom.forms.input", [
            "id" => "user",
            "name" => "user",
            "type" => "text",
            "placeholder" => $user->name,
            "label" => "Solicitante",
            "required" => true,
            "readonly" => true,
            "value" => $user->name,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col">
        <input type="hidden" name="department_id" value="{{ $user->departament->id }}">
         @include("components.custom.forms.input", [
            "id" => "department",
            "name" => "department",
            "type" => "text",
            "placeholder" => "Departamento",
            "label" => "Departamento",
            "required" => true,
            "readonly" => true,
            "value" => $user->departament->name,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col">
        <input type="hidden" name="branch_id" value="{{ $user->branch->id }}">
         @include("components.custom.forms.input", [
            "id" => "branch",
            "name" => "branch",
            "type" => "text",
            "placeholder" => "Sucursal",
            "label" => "Sucursal",
            "required" => true,
            "readonly" => true,
            "value" => $user->branch->name,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>
<div class="row mt-2">
    <div class="col">
         @include("components.custom.forms.input", [
            "id" => "request_date",
            "name" => "request_date",
            "type" => "text",
            "placeholder" => "Fecha de solicitud",
            "label" => "Fecha de solicitud",
            "required" => true,
            "readonly" => true,
            "value" => now(),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    
    <div class="col">
        @include("components.custom.forms.input-select", [
            "id" => "payment_type_id",
            "name" => "payment_type_id",
            "elements" => $payment_types,
            "placeholder" => "Tipo de pago...",
            "value" => isset($order->payment_type_id) ? $order->payment_type_id :  old("payment_type_id"),
            "label" => "Tipo de pago",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col">
        @include("components.custom.forms.input", [
            "id" => "amount",
            "name" => "amount",
            "type" => "numeric",
            "placeholder" => "Costo Total",
            "label" => "Costo Total",
            "required" => true,
            "readonly" => true,
            "value" => 0,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>