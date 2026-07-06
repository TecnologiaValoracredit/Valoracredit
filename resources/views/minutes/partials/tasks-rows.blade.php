@foreach($minute->tasks->sortBy('position') as $task)
    @php
        $statusClass = (\App\Enums\MinuteTaskStatusEnum::tryFrom($task->status))?->badgeClass() ?? 'badge-secondary';
        $priorityClass = (\App\Enums\MinuteTaskPriorityEnum::tryFrom($task->priority))?->badgeClass() ?? 'badge-secondary';
        $isOverdue = $task->due_date && $task->due_date->isPast() && !in_array($task->status, ['completed','canceled']);
    @endphp
    <tr class="task-row" data-task-id="{{ $task->id }}" data-status="{{ $task->status }}">
        <td>
            <textarea class="form-control task-field" data-field="title">{{ $task->title }}</textarea>
            @if($task->parent_task_id)
                <small class="text-muted"><em>Heredada de minuta anterior</em></small>
            @endif
        </td>
        <td>
            <select class="form-control task-field" data-field="assigned_to">
                <option value="">—</option>
                @foreach($users as $id => $name)
                    <option value="{{ $id }}" @selected($task->assigned_to == $id)>{{ $name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select class="form-control task-field" data-field="status">
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" @selected($task->status === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <span class="badge {{ $statusClass }} mt-1">{{ $statuses[$task->status] ?? $task->status }}</span>
        </td>
        <td>
            <select class="form-control task-field" data-field="priority">
                @foreach($priorities as $key => $label)
                    <option value="{{ $key }}" @selected($task->priority === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <span class="badge {{ $priorityClass }} mt-1">{{ $priorities[$task->priority] ?? $task->priority }}</span>
        </td>
        <td>
            <input type="date" class="form-control task-field {{ $isOverdue ? 'border-danger' : '' }}"
                   data-field="due_date"
                   value="{{ optional($task->due_date)->format('Y-m-d') }}">
        </td>
        <td>
            <input type="number" min="0" max="100" class="form-control task-field" data-field="progress" value="{{ $task->progress }}">
            <div class="progress mt-1"><div class="progress-bar" style="width: {{ $task->progress }}%"></div></div>
        </td>
        <td>
            <input type="text" class="form-control task-field" data-field="comments" value="{{ $task->comments }}">
        </td>
        <td class="text-center">
            <a href="{{ route('minutes.tasks.history', ['minute' => $minute->id, 'task' => $task->id]) }}" class="btn btn-outline-primary btn-icon btn-sm" title="Historial">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13a9 9 0 1 0 .5-4"/><polyline points="12 7 12 12 15 15"/></svg>
            </a>
            <button type="button" class="btn btn-outline-danger btn-icon btn-sm task-delete" title="Eliminar">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
        </td>
    </tr>
@endforeach
