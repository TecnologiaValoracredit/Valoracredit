<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        Reporte mensual de minutas
    </x-slot>

    <x-slot:headerFiles>
        @vite(['resources/sass/minutes-reports.scss'])
    </x-slot>

    <div class="row layout-top-spacing">
        @include('components.custom.session-errors')

        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="card-title mb-0">Reporte mensual por usuario</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('minutes.index') }}" class="btn btn-outline-dark">Volver</a>
                    </div>
                </div>

                <form class="row g-2 mt-2" method="GET" action="{{ route('minutes.reports.monthly') }}">
                    <div class="col-md-2">
                        <label class="form-label">Año</label>
                        <input type="number" class="form-control" name="year" min="2020" max="2100" value="{{ $year }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Mes</label>
                        <select class="form-control" name="month">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" @selected($month === $m)>{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Usuario</label>
                        <select class="form-control" name="user_id">
                            <option value="">Todos</option>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}" @selected((int) $userId === (int) $id)>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" type="submit">Aplicar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="minute-report-card">
                    <div class="minute-report-subtitle">Usuarios en reporte</div>
                    <div class="minute-report-kpi">{{ $report['totals']['users'] }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="minute-report-card">
                    <div class="minute-report-subtitle">Tareas del periodo</div>
                    <div class="minute-report-kpi">{{ $report['totals']['tasks'] }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="minute-report-card">
                    <div class="minute-report-subtitle">Completadas del periodo</div>
                    <div class="minute-report-kpi">{{ $report['totals']['completed'] }}</div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-2">Completadas por usuario</h6>
                        <canvas id="chart-monthly-completed" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-2">Cumplimiento por usuario</h6>
                        <canvas id="chart-monthly-compliance" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-2">Resumen por usuario ({{ $report['from']->format('m/Y') }})</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Usuario</th>
                                <th>Total tareas</th>
                                <th>Completadas</th>
                                <th>Pendientes</th>
                                <th>% Cumplimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($report['rows'] as $row)
                                <tr>
                                    <td>{{ $row['name'] }}</td>
                                    <td>{{ $row['total_tasks'] }}</td>
                                    <td>{{ $row['completed_tasks'] }}</td>
                                    <td>{{ $row['pending_tasks'] }}</td>
                                    <td><span class="badge bg-primary">{{ $row['compliance'] }}%</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted">Sin datos para este periodo.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <h6 class="mb-2">Tareas completadas del periodo</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Minuta</th>
                                <th>Tarea</th>
                                <th>Usuario</th>
                                <th>Completada</th>
                                <th>Estatus</th>
                                <th>Avance</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($report['completed_tasks'] as $row)
                                <tr>
                                    <td>{{ $row['minute_title'] }}</td>
                                    <td>{{ $row['task_title'] }}</td>
                                    <td>{{ $row['assignee_name'] }}</td>
                                    <td>{{ $row['completed_at'] }}</td>
                                    <td>{{ $row['status'] }}</td>
                                    <td>{{ $row['progress'] }}%</td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('minutes.tasks.history', ['minute' => $row['minute_id'], 'task' => $row['task_id']]) }}">
                                            Historial
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted">Sin tareas completadas para este periodo.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @php
        $chartConfig = [
            'labels' => $report['chart']['labels'],
            'completed' => $report['chart']['completed'],
            'compliance' => $report['chart']['compliance'],
        ];
    @endphp

    <x-slot:footerFiles>
        <div id="minute-monthly-config" data-config='@json($chartConfig)'></div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        @vite(['resources/js/minutes/monthly-report.js'])
    </x-slot>
</x-base-layout>
