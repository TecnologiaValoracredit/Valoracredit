<x-base-layout :scrollspy="false">
    <x-slot name="pageTitle">
        Modificar requisición
    </x-slot>

    <x-slot name="headerFiles">
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <!-- Aquí puedes incluir estilos adicionales si es necesario -->
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>

    <div class="row layout-top-spacing">
        @include("components.custom.errors")

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Modificar requisición</h5>

                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('requisitions.update', $requisition->id) }}">
                    @csrf
                    @method("PUT")

                    <!-- Información de la requisición (Solicitante, Departamento, etc.) -->
                    <div class="row align-items-start">
                        <div class="col-md-4">
                            <label class="form-label">Solicitante</label>
                            <input type="text" class="form-control" value="{{ $requisition->creator->name }}" readonly>
                            <input type="hidden" name="created_by" value="{{ $requisition->creator->id }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Departamento</label>
                            <input type="text" class="form-control" value="{{ $requisition->departament->name ?? 'No asignado' }}" readonly>
                            <input type="hidden" name="departament_id" value="{{ $requisition->departament->id ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Fecha</label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($requisition->application_date)->format('d/m/Y') }}" readonly>
                            <input type="hidden" name="application_date" value="{{ $requisition->application_date }}">
                        </div>
                    </div>

                    <!-- Campos para `payment_type_id` y `branch_id` -->
                    <div class="row align-items-start">
                        <div class="col-md-4">
                            <label class="form-label">Tipo de pago</label>
                            <select name="payment_type_id" class="form-control" required>
                                <option value="">Seleccione un tipo de pago</option>
                                @foreach($payment_types as $id => $name)
                                    <option value="{{ $id }}" {{ $id == $requisition->payment_type_id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sucursal</label>
                            <select name="branch_id" class="form-control" required>
                                <option value="">Seleccione una sucursal</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $branch->id == $requisition->branch_id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tabla de Pedido (Filas Principales) -->
                    <h4 class="mt-4">Pedido</h4>
                    <div id="rows-container">
                        @foreach ($requisition->requisitionRows as $index => $row)
                            <div class="row row-item">
                                <!-- Row 1: Proveedor, Cantidad, Precio Unitario -->
                                <div class="col-md-4">
                                    <label>Proveedor</label>
                                    <select name="requisition_row[{{ $index }}][supplier_id]" class="form-control" required>
                                        <option value="">Seleccione un proveedor</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ $supplier->id == $row->supplier_id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Cantidad</label>
                                    <input type="number" name="requisition_row[{{ $index }}][amount]" class="form-control amount" value="{{ $row->amount }}" required oninput="updateSubtotal(this)">
                                </div>
                                <div class="col-md-4">
                                    <label>Precio Unitario</label>
                                    <input type="number" step="0.01" name="requisition_row[{{ $index }}][unit_price]" class="form-control" value="{{ $row->unit_price }}" required oninput="updateSubtotal(this)">
                                </div>
                            </div>
                            <div class="row row-item mt-3">
                                <!-- Row 2: Descripción, Subtotal, URL -->
                                <div class="col-md-4">
                                    <label>Descripción</label>
                                    <input type="text" name="requisition_row[{{ $index }}][description]" class="form-control" value="{{ $row->description }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Subtotal</label>
                                    <input type="number" name="requisition_row[{{ $index }}][subtotal]" class="form-control" value="{{ $row->subtotal }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>URL</label>
                                    <input type="url" name="requisition_row[{{ $index }}][url]" class="form-control" value="{{ $row->url }}" required>
                                </div>
                            </div>
                            <div class="row row-item mt-2">
                                <div class="col-md-12">
                                    <!-- Botón para eliminar fila principal -->
                                    <button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar fila</button>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>

                    <!-- Filas Opcionales -->
                    <h4 class="mt-4">Pedido Opcional</h4>
                    <div id="optional-rows-container">
                        @foreach ($requisition->requisitionRowOptional as $index => $optionalRow)
                            <div class="optional-row-block"><!-- Contenedor único para cada optional row -->
                                <!-- Campo oculto con el id (si ya está guardado) -->
                                <input type="hidden" class="optional-row-id" name="requisition_row_optional[{{ $index }}][id]" value="{{ $optionalRow->id }}">

                                <div class="row">
                                    <!-- Row 1: Proveedor, Cantidad, Precio Unitario -->
                                    <div class="col-md-4">
                                        <label>Proveedor</label>
                                        <select name="requisition_row_optional[{{ $index }}][supplier_id]" class="form-control" required>
                                            <option value="">Seleccione un proveedor</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ $supplier->id == $optionalRow->supplier_id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Cantidad</label>
                                        <input type="number" name="requisition_row_optional[{{ $index }}][amount]" class="form-control amount" value="{{ $optionalRow->amount }}" required oninput="updateSubtotal(this)">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Precio Unitario</label>
                                        <input type="number" step="0.01" name="requisition_row_optional[{{ $index }}][unit_price]" class="form-control" value="{{ $optionalRow->unit_price }}" required oninput="updateSubtotal(this)">
                                    </div>
                                </div>

                                <div class="row row-item mt-3">
                                    <!-- Row 2: Descripción, Subtotal, URL -->
                                    <div class="col-md-4">
                                        <label>Descripción</label>
                                        <input type="text" name="requisition_row_optional[{{ $index }}][description]" class="form-control" value="{{ $optionalRow->description }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Subtotal</label>
                                        <input type="number" name="requisition_row_optional[{{ $index }}][subtotal]" class="form-control" value="{{ $optionalRow->subtotal }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label>URL</label>
                                        <input type="url" name="requisition_row_optional[{{ $index }}][url]" class="form-control" value="{{ $optionalRow->url }}" required>
                                    </div>
                                </div>

                                <div class="row row-item mt-2">
                                    <div class="col-md-12">
                                        <!-- Botón para eliminar la optional row completa -->
                                        <button type="button" class="btn btn-danger" onclick="removeOptionalRow(this)">Eliminar fila</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    </div>

                    <!-- Botón para agregar fila opcional -->
                    <button type="button" class="btn btn-success mt-3" onclick="addOptionalRow()">Agregar fila opcional</button>

                    <!-- Total -->
                    <div class="col-md-3 mt-3">
                        <label>Total</label>
                        <input type="number" id="total" class="form-control" value="{{ $requisition->total }}" readonly>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('requisitions.index') }}" class="btn btn-dark">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="footerFiles">
        <script>
            // Obtener el token CSRF desde la etiqueta meta (asegúrate de tenerla en el layout principal)
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

            function addOptionalRow() {
                let container = document.getElementById('optional-rows-container');
                let newRowIndex = container.children.length; // Índice de la nueva fila

                let newRow = `
                    <div class="optional-row-block new-row">
                        <input type="hidden" class="optional-row-id" name="requisition_row_optional[${newRowIndex}][id]" value="">
                        <div class="row">
                            <!-- Row 1: Proveedor, Cantidad, Precio Unitario -->
                            <div class="col-md-4">
                                <label>Proveedor</label>
                                <select name="requisition_row_optional[${newRowIndex}][supplier_id]" class="form-control" required>
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Cantidad</label>
                                <input type="number" name="requisition_row_optional[${newRowIndex}][amount]" class="form-control amount" value="" required oninput="updateSubtotal(this)">
                            </div>
                            <div class="col-md-4">
                                <label>Precio Unitario</label>
                                <input type="number" step="0.01" name="requisition_row_optional[${newRowIndex}][unit_price]" class="form-control" value="" required oninput="updateSubtotal(this)">
                            </div>
                        </div>
                        <div class="row row-item mt-3">
                            <!-- Row 2: Descripción, Subtotal, URL -->
                            <div class="col-md-4">
                                <label>Descripción</label>
                                <input type="text" name="requisition_row_optional[${newRowIndex}][description]" class="form-control" value="" required>
                            </div>
                            <div class="col-md-4">
                                <label>Subtotal</label>
                                <input type="number" name="requisition_row_optional[${newRowIndex}][subtotal]" class="form-control" value="0" readonly>
                            </div>
                            <div class="col-md-4">
                                <label>URL</label>
                                <input type="url" name="requisition_row_optional[${newRowIndex}][url]" class="form-control" value="" required>
                            </div>
                        </div>
                        <div class="row row-item mt-2">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" onclick="removeOptionalRow(this)">Eliminar fila</button>
                            </div>
                        </div>
                        <hr>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', newRow);
            }


            function removeOptionalRow(button, rowId) {
    let container = button.closest('.optional-row-block');

    if (rowId) {
        let url = "{{ route('requisition_row_optionals.destroy', '') }}/" + rowId;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                container.remove();
            } else {
                response.json().then(data => {
                    console.error(data);
                    alert('Error al eliminar la optional row: ' + (data.message || 'Intente nuevamente.'));
                });
            }
        })
        .catch(error => {
            console.error(error);
            alert('Error al eliminar la optional row.');
        });
    } else {
        container.remove();
    }
}




        </script>
    </x-slot>
</x-base-layout>
