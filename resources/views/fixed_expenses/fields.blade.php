<div class="row">
    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "label" => "Nombre",
            "required" => true,
            "value" => isset($expenseType) ? $expenseType->name :  old("name"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    
    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "description",
            "name" => "description",
            "type" => "text",
            "placeholder" => "Descripción...",
            "required" => true,
            "value" => isset($expenseType) ? $expenseType->description :  old("description"),
            "label" => "Descripción",
        ])
    </div>
    
    <div class="mb-2 mt-2 d-flex justify-content-center ">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => isset($expenseType) ? $expenseType->is_active :  true,
            "label" => "Activo",
        ])
    </div>
</div>


<div class="mb-3">
    <b>Seleccione la requisición de referencia para este gasto fijo:</b>
</div>

<div class="overflow-auto mb-2">
    <table class="table">
        <thead>
            <th class="text-center">Selección</th>
            <th>Folio</th>
            <th>Proovedor</th>
            <th>Tipo de gasto</th>
            <th>Notas</th>
            <th>Total</th>
            <th>Origen</th>
        </thead>

        <tbody id="t_body">
            @foreach ($requisitions as $requisition)
            <tr>
                <td class="d-flex justify-content-center">
                    @include("components.custom.forms.input-radio", [
                        "id" => "req-{$requisition->id}",
                        "name" => "req-id",
                        "value" => $requisition->id,
                        "required" => true,
                        "label" => "",
                    ])
                </td>
                <td>{{ $requisition->folio }}</td>
                <td>{{ $requisition->supplier->name }}</td>
                <td>{{ $requisition->expenseType->name }}</td>
                <td>{{ $requisition->notes }}</td>
                <td>&dollar;{{ number_format($requisition->amount, 2) }}</td>
                <td><a href="{{ route('requisitions.show', $requisition->id) }}" class="link-primary" target="_blank">Ver mas</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
