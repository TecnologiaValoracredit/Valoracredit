<div class="row mt-4">
    <div class="col-md-12 d-flex justify-content-start align-items-center">
        <div>
            <label for="folio"><strong>FOLIO: </strong></label>
            <span id="folio">{{ $requisition->folio ?? "No asignado" }}</span>
        </div>                        
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-6">
        <div class="mb-2 mt-2">
            DATOS DE SOLICITANTE
        </div>

        <hr>

        <div>
            <label for="user_employee_number"><strong>Numero de empleado: </strong></label>
            <span id="user_employee_number">{{ $requisition->creator->employee_number ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="creator_name"><strong>Nombre: </strong></label>
            <span id="creator_name">{{ $requisition->creator->name ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="creator_departament"><strong>Departamento: </strong></label>
            <span id="creator_name">{{ $requisition->creator->departament->name ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="creator_name"><strong>Sucursal: </strong></label>
            <span id="creator_name">{{ $requisition->creator->branch->name ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="creator_boss"><strong>Jefe Inmediato: </strong></label>
            <span id="creator_boss">{{ $requisition->boss->name ?? "No asignado" }}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-2 mt-2">
            DATOS DE REQUISICIÓN
        </div>

        <hr>

        <div>
            <label for="current_status"><strong>Estatus: </strong></label>
            <span id="current_status">{{ $requisition->lastLog->toStatusId->name ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="current_status"><strong>Proveedor: </strong></label>
            <span id="current_status">{{ $requisition->supplier->name ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="current_status"><strong>Tipo de Gasto: </strong></label>
            <span id="current_status">{{ $requisition->expenseType->name ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="is_urgent"><strong>Es urgente: </strong></label>
            <span id="is_urgent">{{ $requisition->is_urgent ? "SI" : "NO" }}</span>
        </div>
        <div>
            <label for="request_date"><strong>Fecha de solicitud: </strong></label>
            <span id="request_date">{{ date("d/m/Y H:i", strtotime($requisition->request_date)) ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="payment_type"><strong>Tipo de pago: </strong></label>
            <span id="payment_type">{{ $requisition->paymentType->name ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="requisition_notes"><strong>Notas: </strong></label>
            <span id="requisition_notes">{{ $requisition->notes ?? "No asignado" }}</span>
        </div>
        <div>
            <label for="amount"><strong>Total: </strong></label>
            <span id="amount">&dollar;{{ number_format($requisition->amount, 2) ?? "No asignado" }}</span>
        </div>
    </div>
</div>

<div class="row mb-2 overflow-auto">
    <div class="mb-2 mt-2">
        PRODUCTOS DE REQUISICIÓN
    </div>
    
    <table class="table">
        <thead>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Incluye IVA</th>
            <th>Total</th>
            <th>Evidencias</th>
        </thead>

        <tbody>
            @foreach ($requisition->requisitionRows as $row )
                <tr>
                    <td>{{ $row->product }}</td>
                    <td>{{ $row->product_quantity }}</td>
                    <td>&dollar;{{ number_format($row->product_cost, 2) }}</td>
                    <td>{{ $row->has_iva ? "SI" : "NO" }}</td>
                    <td>&dollar;{{ number_format($row->total_cost, 2) }}</td>
                    <td>
                        <a onclick="requestEvidences({{ $row }}, this)" class="link-primary" type="button" data-bs-toggle="modal" data-bs-target="#reg-modal">Ver</a>
                    </td>

                    <input type="hidden" name="currency_type_id" value="{{ $row->currencyType->name }}">
                </tr>
            @endforeach
        </tbody>
    </table>
</div>