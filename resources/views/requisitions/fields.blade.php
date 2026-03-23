<div class="row mt-2">
    <div class="col-md-4 d-flex flex-column">
        <input type="hidden" name="request_id" value="{{ isset($user) ? $user->id : '' }}">
        <div>
            <label for="user"><strong>Solicitante:</strong></label>
            <span id="user">{{ isset($requisition) ? $requisition->user->name : $user->name }}</span>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-center">
        <input type="hidden" name="departament_id" value="{{ isset($user) ? $user->departament->id : '' }}">
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
            <span id="request_date">{{ isset($requisition) ? date("d/m/Y H:i", strtotime($requisition->request_date)) : date("d/m/Y H:i", strtotime(now())) }}</span>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "expense_type_id",
            "name" => "expense_type_id",
            "elements" => $expense_types,
            "placeholder" => "Tipo de gasto...",
            "value" => isset($requisition) ? $requisition->expense_type_id :  old("expense_type_id"),
            "label" => "Tipo de gasto",
            "readonly" => false,
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "payment_type_id",
            "name" => "payment_type_id",
            "elements" => $payment_types,
            "placeholder" => "Tipo de pago...",
            "value" => isset($requisition) ? $requisition->payment_type_id :  old("payment_type_id"),
            "label" => "Tipo de pago",
            "readonly" => isset($readonly) ? $readonly : false,
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-4">
        @include("components.custom.forms.input-select", [
            "id" => "supplier_id",
            "name" => "supplier_id",
            "elements" => $suppliers,
            "placeholder" => "Selecciona al proveedor...",
            "value" => isset($requisition) ? $requisition->supplier_id :  old("suppliers_id"),
            "label" => "Proveedor",
            "required" => true,
            "readonly" => isset($readonly) ? $readonly : false,
            "invalid_feedback" => "El campo es requerido",
            "addModalBtn" => auth()->user()->hasPermissions('suppliers.create'),
            "targetModal" => "#supplier-add-modal",
        ])
    </div>
</div>
<div class="row mt-2">
    <div class="col-md-12">
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
<div class="d-flex justify-content-center gap-4">
        <div>
            @include("components.custom.forms.input-check", [
                "id" => "is_urgent",
                "name" => "is_urgent",
                "checked" => isset($requisition) ? $requisition->is_urgent :  false,
                "label" => "Urgente",
            ])
        </div>

        @if (!isset($requisition))
            <div>
                @include("components.custom.forms.input-check", [
                    "id" => "is_fixed",
                    "name" => "is_fixed",
                    "checked" => false,
                    "label" => "Gasto Fijo",
                ])
            </div>
        @endif

</div>
<div class="row mt-3 mb-2 m-0">
    <div class="col d-flex justify-content-end">
        <div>
            <label for="requisition_total" class="text-decoration-underline"><strong>Costo Total:</strong></label>
            <span id="requisition_total">&dollar;{{isset($requisition) ? number_format($requisition->amount, 2) : '0.00'}}</span>
        </div>
    </div>
</div>
@if (!isset($requisition) && auth()->user()->hasPermissions('fixed_expenses.getFields'))
    <div class="row collapse" id="fixedExpenseFields">
        <div class="mb-1">
            DETALLES DE GASTO FIJO
        </div>

        <div class="col-md-6 mb-2">
            @include("components.custom.forms.input", [
                "id" => "fixed_expense_name",
                "name" => "fixed_expense_name",
                "type" => "text",
                "placeholder" => "Nombre...",
                "label" => "Nombre",
                "value" => old("fixed_expense_name"),
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
        
        <div class="col-md-6 mb-2">
            @include("components.custom.forms.input", [
                "id" => "fixed_expense_description",
                "name" => "fixed_expense_description",
                "type" => "text",
                "placeholder" => "Descripción...",
                "value" => old("fixed_expense_description"),
                "label" => "Descripción",
            ])
        </div>
    </div>
@endif

<hr>

<div class="row my-3 m-0 mb-4">
    <div class="col">
        <h5>Productos</h5>
    </div>
    <div class="col">
        <div class="text-end">
            <!-- Button trigger modal -->
            <button id="show_btn" type="button" title="Agregar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reg-modal">
                Agregar producto
            </button>
        </div>
    </div>
</div>

<div class="overflow-auto">
    <table class="table">
        <thead>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Incluya IVA</th>
            <th>Porcentaje IVA</th>
            <th>Total</th>
            <th>Acciones</th>
        </thead>
        <tbody id="table_body">
            @if (isset($requisition))
                @foreach ($requisition_rows as $row)
                    <tr>
                        <td>{{ $row->product }}</td>
                        <td>{{ $row->product_quantity }}</td>
                        <td>&dollar;{{ number_format($row->product_cost, 2) }}</td>
                        <td>{{ $row->has_iva ? "Si" : "No" }}</td>
                        <td>{{ $row->iva_percentage == 1 ? "NO APLICA" : $row->iva_percentage }}</td>
                        <td>&dollar;{{ number_format($row->total_cost, 2) }}</td>
                        <td>
                            <a onclick="editProduct(this)" title="Editar" class="btn btn-outline-secondary btn-icon p-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                </svg>
                            </a>
                            <a onclick="deleteProduct(this)" title="Eliminar" class="btn btn-outline-danger btn-outline-danger btn-icon p-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                            </a>
                        </td>
                        <input type="hidden" name="currency_type_id" value={{ $row->currency_type_id }}>
                        <input type="hidden" name="has_iva" value="{{ $row->has_iva ? "on" : "off" }}">
                        <input type="hidden" name="iva_percentage" value="{{ $row->iva_percentage ?? '' }}">
                        <input type="hidden" name="expense_duration_id" value="{{ $row->expense_duration_id ?? '' }}">
                        <input type="hidden" name="starting_date" value="{{ $row->starting_date ?? '' }}">
                        <input type="hidden" name="ending_date" value="{{ $row->ending_date ?? '' }}">
                        <input type="hidden" name="link" value="{{ $row->link ?? '' }}">
                        <input type="hidden" name="product" value="{{ $row->product }}">
                        <input type="hidden" name="product_cost" value="{{ $row->product_cost }}">
                        <input type="hidden" name="product_description" value="{{ $row->product_description }}">
                        <input type="hidden" name="product_quantity" value="{{ $row->product_quantity }}">
                        <input type="hidden" name="reason" value="{{ $row->reason }}">
                        <input type="hidden" name="total_cost" value="{{ $row->total_cost }}">
                        <input type="hidden" name="row_id" value="{{ $row->id }}">
                    </tr>
                @endforeach
            @endif
        </tbody>
        @if (isset($requisition))
            <input id="requisition_id" type="hidden" value="{{ $requisition->id }}">
        @endif
    </table>
</div>
