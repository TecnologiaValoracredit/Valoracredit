<form method="POST" action="{{ route('requisitions.store') }}">
    @csrf

    <!-- NOMBRE DE SOLICITANTE AUTOMÁTICO -->
    <div class="row align-items-start">
        <div class="col-md-4">
            <label for="user" class="form-label">Solicitante</label>
            <input type="text" id="user" class="form-control" value="{{ Auth::user()->name }}" readonly>
            <input type="hidden" name="created_by" value="{{ Auth::id() }}">
        </div>

        <!-- DEPARTAMENTO -->
        <div class="col-4">
            <label for="departament_id" class="form-label">Departamento</label>
            <input type="text" id="departament_id" class="form-control"
                value="{{ Auth::user()->departament ? Auth::user()->departament->name : 'No asignada' }}" disabled>
            <input type="hidden" name="departament_id" value="{{ Auth::user()->departament ? Auth::user()->departament->id : '' }}">
        </div>

        <!-- FECHA ACTUAL -->
        <div class="col-md-4">
            <label for="application_date" class="form-label">Fecha</label>
            <input type="text" id="application_date" class="form-control" value="{{ date('d/m/Y') }}" disabled>
            <input type="hidden" name="application_date" value="{{ date('Y/m/d') }}">
        </div>
    </div>

    <!-- METODO DE PAGO -->
    <div class="row mb-4">
        <div class="col-md-4">
            @include("components.custom.forms.input-select", [
                "id" => "payment_type_id",
                "name" => "payment_type_id",
                "elements" => $payment_types,
                "placeholder" => "Método de pago...",
                "value" => old("payment_type_id"),
                "label" => "Método de pago",
                "required" => true,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>

        <!-- SUCURSAL -->
        <div class="col-md-4">
            <label for="branch_id" class="form-label">Sucursal</label>
            <input type="text" id="branch_id" class="form-control"
                value="{{ Auth::user()->branch ? Auth::user()->branch->name : 'No asignada' }}" disabled>
            <input type="hidden" name="branch_id" value="{{ Auth::user()->branch ? Auth::user()->branch->id : '' }}">
        </div>
    </div>

    <br>

   <!-- Tabla de Pedido (fila inicial en "rows") -->
   <h4>Pedido</h4>
   <div id="rows-container">
        <!-- Fila inicial -->
        <div class="row row-item">
            <div class="col-md-4">
                <label for="rows[0][supplier_id]">Proveedor</label>
                <select name="rows[0][supplier_id]" class="form-control" required>
                    <option value="">Seleccione un proveedor</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="rows[0][amount]">Cantidad</label>
                <input type="number" name="rows[0][amount]" class="form-control amount" value="1" required oninput="updateSubtotal(this)">
            </div>

            <div class="col-md-4">
                <label for="rows[0][unit_price]">Precio Unitario</label>
                <input type="number" step="0.01" name="rows[0][unit_price]" class="form-control" required oninput="updateSubtotal(this)">
            </div>
        </div>

        <div class="row mt-3 row-item">
            <div class="col-md-4">
                <label for="rows[0][description]">Descripción</label>
                <input type="text" name="rows[0][description]" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="rows[0][subtotal]">Subtotal</label>
                <input type="number" name="rows[0][subtotal]" class="form-control" readonly>
            </div>

            <div class="col-md-4">
                <label for="rows[0][url]">URL</label>
                <input type="url" name="rows[0][url]" class="form-control" required>
            </div>
        </div>

        <div class="col-md-3">
            <!-- Campo oculto para enviar 0 si el checkbox no se marca -->
            <input type="hidden" name="rows[0][include_iva]" value="0">
            <!-- Checkbox específico para incluir IVA (activado por defecto) -->
            <input type="checkbox" name="rows[0][include_iva]" value="1" class="form-check-input"  onchange="updateSubtotal(this)">
            <label class="form-check-label">Incluir IVA</label>
        </div>
   </div>

   <!-- Contenedor para las filas opcionales (se guardarán en "requisition_row_optional") -->
   <div id="optional-rows-container"></div>

    <!-- Total -->
    <div class="col-md-3">
        <label for="total">Total</label>
        <input type="number" id="total" class="form-control" readonly>
    </div>

    <!-- Botón para agregar filas opcionales -->
    <button type="button" class="btn btn-primary mt-3" onclick="addRow()">Agregar Pedido</button>

    <div class="mb-2">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => old("is_active", 1),
            "label" => "Activo",
        ])
    </div>
</form>

<style>
    /* Estilos para diferenciar filas nuevas */
    .new-row {
        background-color: #e6f7ff; /* Fondo azul claro */
    }
</style>

<script>
    // Función para calcular el subtotal para la fila correspondiente.
    // Se detecta el prefijo (rows o requisition_row_optional) en el atributo name.
    function updateSubtotal(element) {
        let nameAttr = element.getAttribute('name');
        // Determinar el prefijo según si el name contiene "rows[" o "requisition_row_optional["
        let type = nameAttr.indexOf('rows[') !== -1 ? 'rows' : 'requisition_row_optional';
        let regex = new RegExp(type + '\\[(\\d+)\\]');
        let match = nameAttr.match(regex);
        if (!match) return;
        let index = match[1];

        // Seleccionar los campos correspondientes usando el prefijo definido
        let amountInput = document.querySelector('input[name="' + type + '[' + index + '][amount]"]');
        let unitPriceInput = document.querySelector('input[name="' + type + '[' + index + '][unit_price]"]');
        let subtotalInput = document.querySelector('input[name="' + type + '[' + index + '][subtotal]"]');
        let includeIvaCheckbox = document.querySelector('input[name="' + type + '[' + index + '][include_iva]"][type="checkbox"]');
        if (!amountInput || !unitPriceInput || !subtotalInput || !includeIvaCheckbox) return;

        let amount = parseFloat(amountInput.value) || 0;
        let unitPrice = parseFloat(unitPriceInput.value) || 0;
        let includeIva = includeIvaCheckbox.checked;

        let subtotal = amount * unitPrice;
        if (includeIva) {
            subtotal *= 1.16; // Aplica IVA del 16%
        }

        subtotalInput.value = subtotal.toFixed(2);
        updateTotal();
    }

    // Función para actualizar el total acumulado de todos los subtotales
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('input[name$="[subtotal]"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        let totalInput = document.getElementById('total');
        if (totalInput) {
            totalInput.value = total.toFixed(2);
        }
    }

    // Función para agregar una nueva fila opcional, cuyos campos se guardarán en requisition_row_optional
    function addRow() {
        // Calculamos el índice en el contenedor de filas opcionales
        let index = document.querySelectorAll('#optional-rows-container .row-item').length;
        let rowHtml = `
            <div class="row mt-4 row-item new-row">
                <div class="col-md-4">
                    <label for="requisition_row_optional[${index}][supplier_id]">Proveedor</label>
                    <select name="requisition_row_optional[${index}][supplier_id]" class="form-control" required>
                        <option value="">Seleccione un proveedor</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="requisition_row_optional[${index}][amount]">Cantidad</label>
                    <input type="number" name="requisition_row_optional[${index}][amount]" class="form-control amount" value="1" required oninput="updateSubtotal(this)">
                </div>

                <div class="col-md-4">
                    <label for="requisition_row_optional[${index}][unit_price]">Precio Unitario</label>
                    <input type="number" step="0.01" name="requisition_row_optional[${index}][unit_price]" class="form-control" required oninput="updateSubtotal(this)">
                </div>
            </div>

            <div class="row mt-3 row-item new-row">
                <div class="col-md-4">
                    <label for="requisition_row_optional[${index}][description]">Descripción</label>
                    <input type="text" name="requisition_row_optional[${index}][description]" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label for="requisition_row_optional[${index}][subtotal]">Subtotal</label>
                    <input type="number" name="requisition_row_optional[${index}][subtotal]" class="form-control" readonly>
                </div>

                <div class="col-md-4">
                    <label for="requisition_row_optional[${index}][url]">URL</label>
                    <input type="url" name="requisition_row_optional[${index}][url]" class="form-control" required>
                </div>
            </div>

            <div class="row mt-3 row-item new-row">
                <div class="col-md-12">
                    <input type="hidden" name="requisition_row_optional[${index}][include_iva]" value="0">
                    <input type="checkbox" name="requisition_row_optional[${index}][include_iva]" value="1" class="form-check-input" onchange="updateSubtotal(this)">
                    <label class="form-check-label">Incluir IVA</label>
                </div>
            </div>
        `;

        document.getElementById('optional-rows-container').insertAdjacentHTML('beforeend', rowHtml);
    }
</script>

