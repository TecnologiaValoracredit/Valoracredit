@if (
        ($requisition->roleApprovedApproval("Dirección general") || $requisition->roleDeniedApproval("Dirección general")) ||
        ($requisition->roleApprovedApproval("Admin") || $requisition->roleDeniedApproval("Admin"))
    )
    <div class="text-center px-3 py-2">
        <strong>{{ $requisition->lastApproval->decision }}</strong>
    </div>
@else
    <div class="d-flex justify-content-center">
        <div class="fw-bold">Decisión</div>
    </div>
    <div class="d-flex justify-content-center px-3 py-2">
        <div class="toggle-btn btn btn-primary w-50">
            Alternar
        </div>
    </div>
    <div class="px-3 py-1 mb-3>
        @include("components.custom.forms.input-select", [
            "id" => "req-{$requisition->id}-decision",
            "name" => "req-{$requisition->id}-decision",
            "elements" => ['Aprobada' => 'Aprobar', 'Devuelta' => 'Devolver', 'Rechazada' => 'Rechazar'],
            "placeholder" => "Decision...",
            "value" => 'Aprobada',
            "label" => "",
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>
    <div class="notes-collapsable collapse">
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