@php
    $requestedDates = $vacation->dates->sortBy('date')->values();
    $firstRequestedDate = optional($requestedDates->first())->date;
    $lastRequestedDate = optional($requestedDates->last())->date;
    $hrApproval = $vacation->hrOrWithPermissionsApproval('vacations.seeAllVacations');
    $bossApproval = $vacation->bossApproval();
    $balanceLabel = match ($vacation->balance_used) {
        'Normal' => 'Saldo normal',
        'Advance' => 'Días en avance',
        default => 'Saldo no especificado',
    };
    $decisionTone = function ($decision) {
        $normalizedDecision = strtolower((string) $decision);

        if (str_contains($normalizedDecision, 'aprob')) {
            return 'success';
        }

        if (str_contains($normalizedDecision, 'rech') || str_contains($normalizedDecision, 'deny') || str_contains($normalizedDecision, 'deneg')) {
            return 'danger';
        }

        return 'secondary';
    };
    $formatVacationDate = function ($value) {
        return ucfirst(\Carbon\Carbon::parse($value)->locale('es')->translatedFormat('d/m/Y (l)'));
    };
@endphp

<div class="row g-3 mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-3">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Resumen de vacaciones</div>
                        <h4 class="mb-1 text-black">Solicitud de {{ $vacation->user->name ?? 'No asignado' }}</h4>
                        <div class="text-muted small">Creada el {{ date('d/m/Y', strtotime($vacation->created_at)) }}</div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="h-100 rounded-3 border bg-light p-3">
                            <div class="text-muted small text-uppercase fw-semibold mb-1">Días que tenía</div>
                            <div class="fs-2 fw-bold text-dark mb-1">{{ $vacation->days_available_before ?? 'N/D' }}</div>
                            <div class="small text-muted">Saldo disponible antes de esta solicitud</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="h-100 rounded-3 border bg-primary bg-gradient text-white p-3">
                            <div class="small text-uppercase fw-semibold mb-1">Días solicitados</div>
                            <div class="fs-2 fw-bold mb-1">{{ $vacation->total_days }}</div>
                            <div class="small opacity-75">Cantidad apartada en esta solicitud</div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-4">
                        <div class="h-100 rounded-3 border bg-light p-3">
                            <div class="text-muted small text-uppercase fw-semibold mb-1">Días que le quedan</div>
                            <div class="fs-2 fw-bold text-success mb-1">{{ $vacation->days_available_after ?? 'N/D' }}</div>
                            <div class="small text-muted">Saldo después de registrar la solicitud</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 p-md-4">
                <div class="text-uppercase text-muted small fw-semibold mb-3">Datos del solicitante</div>
                <div class="rounded-3 bg-light p-3 mb-3">
                    <div class="text-muted small mb-1">Nombre</div>
                    <div class="fw-semibold fs-5 text-break">{{ $vacation->user->name ?? 'No asignado' }}</div>
                </div>
                <div class="rounded-3 bg-light p-3">
                    <div class="text-muted small mb-1">Jefe inmediato</div>
                    <div class="fw-semibold fs-6 text-break">{{ $vacation->boss->name ?? 'No asignado' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 p-md-4">
                <div class="text-uppercase text-muted small fw-semibold mb-3">Datos de la solicitud</div>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="rounded-3 bg-light p-3 h-100">
                            <div class="text-muted small mb-1">Razón</div>
                            <div class="fw-semibold text-break">{{ $vacation->reason ?: 'No especificada' }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rounded-3 bg-light p-3 h-100">
                            <div class="text-muted small mb-1">Notas</div>
                            <div class="text-break">{{ $vacation->notes ?: 'Sin notas registradas' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                    <div>
                        <div class="text-uppercase text-muted small fw-semibold">Fechas solicitadas</div>
                    </div>
                    <div class="small text-muted">{{ $requestedDates->count() }} fecha(s) registrada(s)</div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @forelse ($requestedDates as $date)
                        <div class="px-3 py-2 rounded-3 border bg-light fw-semibold text-dark">
                            {{ $formatVacationDate($date->date) }}
                        </div>
                    @empty
                        <div class="text-muted">No hay fechas registradas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                    <div class="text-uppercase text-muted small fw-semibold">Decisión y notas - RH</div>
                    <span class="badge text-bg-{{ $decisionTone(optional($hrApproval)->decision) }} px-3 py-2">
                        {{ optional($hrApproval)->decision ?? 'Pendiente' }}
                    </span>
                </div>
                <div class="rounded-3 bg-light p-3">
                    <div class="text-muted small mb-1">Notas</div>
                    <div class="text-break">{{ optional($hrApproval)->notes ?: 'Notas no ingresadas' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                    <div class="text-uppercase text-muted small fw-semibold">Decisión y notas - Jefe inmediato</div>
                    <span class="badge text-bg-{{ $decisionTone(optional($bossApproval)->decision) }} px-3 py-2">
                        {{ optional($bossApproval)->decision ?? 'Pendiente' }}
                    </span>
                </div>
                <div class="rounded-3 bg-light p-3">
                    <div class="text-muted small mb-1">Notas</div>
                    <div class="text-break">{{ optional($bossApproval)->notes ?: 'Notas no ingresadas' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>