<div class="row mb-4">
    <div class="col-md-4 d-flex align-items-end">
        <div>
            <label for="user"><strong>Solicita: </strong></label>
            <span id="user">{{ isset($requisition_global) ? $requisition_global->creator->name : auth()->user()->name }}</span>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div>
            <label for="request_date"><strong>Fecha de solicitud: </strong></label>
            <span id="request_date">{{ isset($requisition_global) ? date("d/m/Y", strtotime($requisition_global->created_at)) : date("d/m/Y", strtotime(now())) }}</span>
        </div>
    </div>
    <div class="col-md-4">
        @include("components.custom.forms.input", [
            "id" => "application_date",
            "name" => "application_date",
            "type" => "date",
            "placeholder" => "Fecha de aplicación...",
            "value" => isset($requisition_global) ? $requisition_global->application_date :  old("application_date"),
            "label" => "Fecha de aplicación",
            "required" => true,
        ])
    </div>
</div>
<div class="row mb-2">
    <p>Elija las requisiciones que conformarán la global:</p>
</div>

<div class="overflow-auto">
    <table class="table">
        <thead>
            <th class="text-center">Selección   <span id="select_all_btn" class="add-supplier-btn">&darr;</span></th>
            <th>Folio</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Origen</th>
        </thead>

        <tbody id="t_body">
            @foreach ($requisitions as $requisition)
            <tr>
                <td class="d-flex justify-content-center">
                    @include("components.custom.forms.input-check", [
                        "id" => "req-{$requisition->id}",
                        "name" => "req-{$requisition->id}",
                        "checked" => true,
                        "label" => "",
                    ])
                </td>
                <td>{{ $requisition->folio }}</td>
                <td>{{ $requisition->user->name }}</td>
                <td>{{ date("d/m/Y", strtotime($requisition->request_date)) }}</td>
                <td>&dollar;{{ number_format($requisition->amount, 2) }}</td>
                <td><a href="{{ route('requisitions.show', $requisition->id) }}" class="link-primary" target="_blank">Ver mas</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
