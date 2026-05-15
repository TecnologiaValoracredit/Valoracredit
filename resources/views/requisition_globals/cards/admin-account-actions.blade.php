@if ($requisition->roleReturnedApproval('Contabilidad') || $requisition->roleReturnedApproval('Administración'))
    <div class="d-flex justify-content-center align-item-center">
        <span class="badge badge-danger">Devuelta</span>
    </div>
@elseif($requisition->roleApprovedApproval('Contabilidad') && $requisition->roleApprovedApproval('Administración') || $requisition->adminSignatureApproval())
    <div class="d-flex justify-content-center align-item-center">
        <span class="badge badge-success">Aprobada</span>
    </div>
@else
    <div class="text-center fw-bolder px-3 py-2">
        Aprobar
    </div>
    <div class="d-flex justify-content-center align-items-center px-3 py-2">
        @include("components.custom.forms.input-check", [
            "id" => "req-{$requisition->id}",
            "name" => "req-{$requisition->id}",
            "checked" => true,
            "label" => "",
        ])
    </div>
    <div class="collapse">
        <div class="px-3 py-2">
            @include("components.custom.forms.input", [
            "id" => "req-{$requisition->id}-notes",
            "name" => "req-{$requisition->id}-notes",
            "type" => "text",
            "placeholder" => "Notas...",
            "label" => "",
            "value" => old("req-{$requisition->id}-decision"),
            "invalid_feedback" => "El campo es requerido",
        ])
        </div>
    </div>
@endif