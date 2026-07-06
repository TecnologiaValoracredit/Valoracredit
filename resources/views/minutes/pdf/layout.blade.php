<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Minuta {{ $minute->id }}</title>
    <style>
        * { font-family: DejaVu Sans, sans-serif; }
        body { font-size: 11px; color: #222; }
        h1 { font-size: 16px; margin: 0; }
        h2 { font-size: 13px; margin: 12px 0 4px; border-bottom: 1px solid #999; padding-bottom: 2px; }
        .header { text-align: center; margin-bottom: 12px; }
        .header small { color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        th, td { border: 1px solid #999; padding: 4px 6px; text-align: left; vertical-align: top; }
        th { background: #eef; }
        .meta td { border: none; padding: 2px 6px; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; font-size: 10px; color: #fff; }
        .b-pending     { background: #f0ad4e; }
        .b-in_progress { background: #5bc0de; }
        .b-completed   { background: #5cb85c; }
        .b-canceled    { background: #d9534f; }
        .summary-grid td { width: 25%; }
        .summary-label { color: #555; font-size: 10px; }
        .summary-value { font-size: 15px; font-weight: bold; margin-top: 2px; }
        .task-overdue td { background: #ffe9e9; }
        .task-due-today td { background: #fff4dd; }
        .due-text-danger { color: #c9302c; font-weight: bold; }
        .due-text-warn { color: #8a6d3b; font-weight: bold; }
        .due-text-ok { color: #3c763d; }
        .pill-overdue {
            display: inline-block;
            margin-left: 4px;
            background: #c9302c;
            color: #fff;
            border-radius: 8px;
            padding: 1px 5px;
            font-size: 9px;
        }
        .annex-row td {
            background: #f8f9fb;
            font-size: 10px;
            color: #333;
        }
        .annex-title {
            font-weight: bold;
            margin-bottom: 2px;
        }
        .logo{
            position: absolute;
            top: 0px;
            left: 0px;
            width: 80px;
        }
    </style>
</head>
<body>
    @php
        $today = \Illuminate\Support\Carbon::today();
        $completedCurrentMonth = $completedCurrentMonth ?? collect();
    @endphp

    <div class="header">
        <img src="{{ public_path('images/logo 2 tintas.png') }}" class="logo">
        <h1>Minuta de Reunión</h1>
        <small>Impreso el {{ now()->format('d/m/Y H:i') }}</small>
    </div>
    <hr>

    <table class="meta">
        <tr>
            <td style="width:20%"><strong>Título:</strong></td>
            <td>{{ $minute->title }}</td>
            <td style="width:20%"><strong>Fecha:</strong></td>
            <td>{{ optional($minute->meeting_date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Inicio:</strong></td><td>{{ $minute->start_time ?? '—' }}</td>
            <td><strong>Fin:</strong></td><td>{{ $minute->end_time ?? '—' }}</td>
        </tr>
        <tr>
            <td><strong>Creada por:</strong></td>
            <td colspan="3">{{ optional($minute->creator)->name }}</td>
        </tr>
    </table>

    @if($minute->notes)
        <h2>Notas / Agenda</h2>
        <div>{!! nl2br(e($minute->notes)) !!}</div>
    @endif

    <h2>Participantes</h2>
    @if($minute->participants->isEmpty())
        <p>Sin participantes registrados.</p>
    @else
        <table>
            <thead><tr><th>Usuario</th><th>Asistencia</th></tr></thead>
            <tbody>
                @foreach($minute->participants as $p)
                    @php $att = ['present'=>'Presente','absent'=>'Ausente','excused'=>'Justificado'][$p->attendance_status] ?? '—'; @endphp
                    <tr>
                        <td>{{ optional($p->user)->name }}</td>
                        <td>{{ $att }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Tareas / Acuerdos</h2>
    @if($minute->tasks->isEmpty())
        <p>Sin tareas registradas.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Tarea</th><th>Responsable</th><th>Estatus</th>
                    <th>Prioridad</th><th>Compromiso</th><th>Días</th><th>Avance</th>
                </tr>
            </thead>
            <tbody>
                @php $statuses = \App\Enums\MinuteTaskStatusEnum::labels(); $priorities = \App\Enums\MinuteTaskPriorityEnum::labels(); @endphp
                @foreach($minute->tasks->sortBy('position') as $i => $task)
                    @php
                        // Reglas visuales para vencimiento solo en tareas abiertas.
                        $isClosed = in_array($task->status, ['completed', 'canceled']);
                        $showAnnex = in_array($task->status, ['pending', 'in_progress']);
                        $isOverdue = $task->due_date && $task->due_date->lt($today) && !$isClosed;
                        $isDueToday = $task->due_date && $task->due_date->isSameDay($today) && !$isClosed;
                        $rowClass = $isOverdue ? 'task-overdue' : ($isDueToday ? 'task-due-today' : '');

                        // Historial de cambios de fecha compromiso para el anexo.
                        $dueDateUpdates = $task->updates
                            ->filter(function ($update) {
                                if ($update->field instanceof \App\Enums\MinuteTaskUpdateFieldEnum) {
                                    return $update->field === \App\Enums\MinuteTaskUpdateFieldEnum::DUE_DATE;
                                }

                                return (string) $update->field === \App\Enums\MinuteTaskUpdateFieldEnum::DUE_DATE->value;
                            })
                            ->sortBy('created_at')
                            ->values();

                        if ($task->due_date) {
                            $daysDiff = $today->diffInDays($task->due_date, false);
                            if ($daysDiff < 0) {
                                $dueText = 'Vencida hace ' . abs($daysDiff) . ' día(s)';
                                $dueClass = 'due-text-danger';
                            } elseif ($daysDiff === 0) {
                                $dueText = 'Vence hoy';
                                $dueClass = 'due-text-warn';
                            } else {
                                $dueText = 'Faltan ' . $daysDiff . ' día(s)';
                                $dueClass = 'due-text-ok';
                            }
                        } else {
                            $dueText = '—';
                            $dueClass = '';
                        }
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $task->title }}@if($task->description)<br><small>{{ $task->description }}</small>@endif</td>
                        <td>{{ optional($task->assignee)->name ?? '—' }}</td>
                        <td>
                            <span class="badge b-{{ $task->status }}">{{ $statuses[$task->status] ?? $task->status }}</span>
                        </td>
                        <td>{{ $priorities[$task->priority] ?? $task->priority }}</td>
                        <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : '—' }}</td>
                        <td class="{{ $dueClass }}">{{ $dueText }}</td>
                        <td>{{ $task->progress }}%</td>
                    </tr>

                    @if($showAnnex)
                        <tr class="annex-row">
                            <td colspan="8">
                                <div class="annex-title">Anexo: cambios de fecha compromiso</div>
                                @if($dueDateUpdates->isEmpty())
                                    Sin cambios registrados.
                                @else
                                    {{-- Se imprime cada cambio con: fecha/hora, antes -> despues, y usuario. --}}
                                    @foreach($dueDateUpdates as $chg)
                                        @php
                                            $oldDate = $chg->old_value ? \Illuminate\Support\Carbon::parse($chg->old_value)->format('d/m/Y') : '—';
                                            $newDate = $chg->new_value ? \Illuminate\Support\Carbon::parse($chg->new_value)->format('d/m/Y') : '—';
                                            $changedAt = \Illuminate\Support\Carbon::parse($chg->created_at)->format('d/m/Y H:i');
                                        @endphp
                                        • {{ $changedAt }} | {{ $oldDate }} → {{ $newDate }} | {{ optional($chg->user)->name ?? 'Sistema' }}<br>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Resumen</h2>
    <table class="summary-grid">
        <tr>
            <td>
                <div class="summary-label">Total de tareas</div>
                <div class="summary-value">{{ $metrics['total'] }}</div>
            </td>
            <td>
                <div class="summary-label">Pendientes</div>
                <div class="summary-value">{{ $metrics['pending'] }}</div>
            </td>
            <td>
                <div class="summary-label">Completadas</div>
                <div class="summary-value">{{ $metrics['completed'] }}</div>
            </td>
            <td>
                <div class="summary-label">Vencidas</div>
                <div class="summary-value">{{ $metrics['overdue'] }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="summary-label">Cumplimiento general</div>
                <div class="summary-value">{{ $metrics['compliance'] }}%</div>
            </td>
            <td colspan="2">
                <div class="summary-label">Mes actual</div>
                <div class="summary-value">{{ now()->format('m/Y') }}</div>
            </td>
        </tr>
    </table>

    <h2>Tareas terminadas en el mes actual ({{ now()->format('m/Y') }})</h2>
    @if($completedCurrentMonth->isEmpty())
        <p>No hay tareas terminadas en el mes actual.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Minuta</th>
                    <th>Tarea</th>
                    <th>Responsable</th>
                    <th>Fecha de término</th>
                    <th>Avance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($completedCurrentMonth->values() as $i => $task)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ optional($task->minute)->title ?? '—' }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ optional($task->assignee)->name ?? '—' }}</td>
                        <td>{{ optional($task->completed_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $task->progress }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
