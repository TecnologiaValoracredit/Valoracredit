<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        Minuta: {{ $minute->title }}
    </x-slot>

    <x-slot:headerFiles>
        @vite(['resources/sass/minutes-show.scss'])
    </x-slot>

    <input type="hidden" id="route" value="minutes">

    <div class="row layout-top-spacing">
        @include("components.custom.session-errors")

        {{-- HEADER --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <h4 class="mb-1">{{ $minute->title }}</h4>
                        <div class="text-muted">
                            <strong>Fecha:</strong> {{ optional($minute->meeting_date)->format('d/m/Y') }}
                            @if($minute->start_time) &nbsp;|&nbsp; <strong>Inicio:</strong> {{ $minute->start_time }} @endif
                            @if($minute->end_time)   &nbsp;|&nbsp; <strong>Fin:</strong> {{ $minute->end_time }} @endif
                            &nbsp;|&nbsp; <strong>Creada por:</strong> {{ optional($minute->creator)->name }}
                        </div>
                        @if($minute->notes)
                            <p class="mt-2 mb-0">{!! nl2br(e($minute->notes)) !!}</p>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('minutes.index') }}" class="btn btn-outline-dark">Volver</a>
                        <a href="{{ route('minutes.reports.monthly') }}" class="btn btn-outline-primary">Reporte mensual</a>
                        <a href="{{ route('minutes.edit', $minute->id) }}" class="btn btn-outline-secondary">Editar</a>
                        <a href="{{ route('minutes.exportPdf', $minute->id) }}" target="_blank" class="btn btn-outline-danger">PDF</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- METRICS --}}
        <div class="row g-3 mb-3">
            <div class="col-md-3"><div class="minute-metric-card bg-grad-warning"><small>Pendientes</small><h2>{{ $metrics['pending'] }}</h2></div></div>
            <div class="col-md-3"><div class="minute-metric-card bg-grad-success"><small>Completadas</small><h2>{{ $metrics['completed'] }}</h2></div></div>
            <div class="col-md-3"><div class="minute-metric-card bg-grad-danger"><small>Vencidas</small><h2>{{ $metrics['overdue'] }}</h2></div></div>
            <div class="col-md-3"><div class="minute-metric-card bg-grad-primary"><small>Cumplimiento</small><h2>{{ $metrics['compliance'] }}%</h2></div></div>
        </div>

        {{-- PARTICIPANTS --}}
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Participantes</h5>
                @if($minute->participants->isEmpty())
                    <p class="text-muted mb-0">Sin participantes registrados.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead><tr><th>Usuario</th><th>Asistencia</th></tr></thead>
                        <tbody>
                        @foreach($minute->participants as $p)
                            <tr>
                                <td>{{ optional($p->user)->name }}</td>
                                <td>
                                    @php $att = ['present'=>'Presente','absent'=>'Ausente','excused'=>'Justificado'][$p->attendance_status] ?? '—'; @endphp
                                    {{ $att }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        {{-- TASKS --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="card-title mb-0">Tareas / Acuerdos</h5>
                    <div class="d-flex gap-2">
                        <input type="text" id="task-filter" class="form-control form-control-sm" placeholder="Buscar..." style="max-width:220px;">
                        <select id="task-status-filter" class="form-control form-control-sm" style="max-width:180px;">
                            <option value="">Todos los estatus</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover minute-tasks-table" id="tasks-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width:28%">Tarea</th>
                                <th>Responsable</th>
                                <th>Estatus</th>
                                <th>Prioridad</th>
                                <th>Compromiso</th>
                                <th>Avance</th>
                                <th>Comentarios</th>
                                <th style="width:90px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include("minutes.partials.tasks-rows")
                            <tr id="new-task-row" class="table-light">
                                <td><textarea id="new-title" class="form-control" placeholder="Nueva tarea..."></textarea></td>
                                <td>
                                    <select id="new-assigned" class="form-control">
                                        <option value="">—</option>
                                        @foreach($users as $id => $name)<option value="{{ $id }}">{{ $name }}</option>@endforeach
                                    </select>
                                </td>
                                <td>
                                    <select id="new-status" class="form-control">
                                        @foreach($statuses as $key => $label)<option value="{{ $key }}">{{ $label }}</option>@endforeach
                                    </select>
                                </td>
                                <td>
                                    <select id="new-priority" class="form-control">
                                        @foreach($priorities as $key => $label)<option value="{{ $key }}" @if($key==='medium') selected @endif>{{ $label }}</option>@endforeach
                                    </select>
                                </td>
                                <td><input type="date" id="new-due" class="form-control"></td>
                                <td><input type="number" id="new-progress" class="form-control" min="0" max="100" value="0"></td>
                                <td><input type="text" id="new-comments" class="form-control" placeholder="—"></td>
                                <td class="text-center">
                                    <button type="button" id="btn-add-task" class="btn btn-success btn-sm">+</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- CHARTS --}}
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="card"><div class="card-body">
                    <h5 class="card-title">Tareas por responsable</h5>
                    <canvas id="chart-assignees" height="180"></canvas>
                </div></div>
            </div>
            <div class="col-md-6">
                <div class="card"><div class="card-body">
                    <h5 class="card-title">Cumplimiento semanal</h5>
                    <canvas id="chart-weekly" height="180"></canvas>
                </div></div>
            </div>
        </div>
    </div>

    @php
        $minuteConfig = [
            'id' => $minute->id,
            'storeTaskUrl' => route('minutes.tasks.store', $minute->id),
            'updateTaskUrl' => url('minutes/' . $minute->id . '/tasks'),
            'csrf' => csrf_token(),
            'metrics' => $metrics,
            'weekly' => $weekly,
            'statuses' => $statuses,
            'priorities' => $priorities,
        ];
    @endphp

    <x-slot:footerFiles>
        <div
            id="minute-config"
            data-config='@json($minuteConfig)'
        ></div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        @vite(['resources/js/minutes/show.js'])
    </x-slot>
</x-base-layout>
