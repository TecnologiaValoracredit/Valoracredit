<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        Historial de tarea
    </x-slot>

    <x-slot:headerFiles>
        @vite(['resources/sass/minutes-reports.scss'])
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="card-title mb-1">Historial de cambios de tarea</h5>
                        <div class="text-muted">
                            <strong>Minuta:</strong> {{ $minute->title }} |
                            <strong>Tarea:</strong> {{ $task->title }} |
                            <strong>Responsable:</strong> {{ optional($task->assignee)->name ?? 'Sin asignar' }}
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('minutes.reports.monthly') }}" class="btn btn-outline-secondary">Reporte mensual</a>
                        <a href="{{ route('minutes.show', $minute->id) }}" class="btn btn-outline-dark">Volver a minuta</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-2">Línea de tiempo</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm minute-history-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha/Hora</th>
                                <th>Usuario</th>
                                <th>Campo</th>
                                <th>Valor anterior</th>
                                <th>Valor nuevo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history['timeline'] as $row)
                                <tr>
                                    <td>{{ $row['when'] }}</td>
                                    <td>{{ $row['user'] }}</td>
                                    <td><span class="badge bg-secondary minute-field-badge">{{ $row['field_label'] }}</span></td>
                                    <td>{{ is_null($row['old']) ? '—' : $row['old'] }}</td>
                                    <td>{{ is_null($row['new']) ? '—' : $row['new'] }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Sin movimientos registrados para esta tarea.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-2">Avance mensual (último valor por mes)</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mes</th>
                                <th>Avance %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history['monthly_progress'] as $row)
                                <tr>
                                    <td>{{ $row['label'] }}</td>
                                    <td>{{ $row['progress'] }}%</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted">Sin cambios de avance registrados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footerFiles></x-slot>
</x-base-layout>
