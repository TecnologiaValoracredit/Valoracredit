<?php

namespace App\Services;

use App\Enums\MinuteStatusEnum;
use App\Enums\MinuteTaskPriorityEnum;
use App\Enums\MinuteTaskStatusEnum;
use App\Enums\MinuteTaskUpdateFieldEnum;
use App\Models\Minute;
use App\Models\MinuteParticipant;
use App\Models\MinuteTask;
use App\Models\MinuteTaskUpdate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MinuteService
{
    /**
    * Crea una nueva minuta, registra participantes y copia tareas pendientes de la minuta anterior.
     *
     * @return array [bool $status, ?string $error, ?Minute $minute]
     */
    public function store(Request $request): array
    {
        try {
            $minute = DB::transaction(function () use ($request) {
                $minute = Minute::create([
                    'title'        => $request->title,
                    'meeting_date' => $request->meeting_date,
                    'start_time'   => $request->start_time,
                    'end_time'     => $request->end_time,
                    'notes'        => $request->notes,
                    'status'       => MinuteStatusEnum::OPEN->value,
                    'created_by'   => auth()->id(),
                    'is_active'    => true,
                ]);

                $this->syncParticipants($minute, (array) $request->input('participants', []));

                $this->copyPendingTasksFromPrevious($minute);

                return $minute;
            });
        } catch (\Throwable $e) {
            return [false, $e->getMessage(), null];
        }

        return [true, null, $minute];
    }

    public function update(Request $request, Minute $minute): array
    {
        try {
            DB::transaction(function () use ($request, $minute) {
                $minute->update([
                    'title'        => $request->title,
                    'meeting_date' => $request->meeting_date,
                    'start_time'   => $request->start_time,
                    'end_time'     => $request->end_time,
                    'notes'        => $request->notes,
                    'status'       => $request->status ?? $minute->status,
                ]);

                if ($request->has('participants')) {
                    $this->syncParticipants($minute, (array) $request->input('participants', []));
                }
            });
        } catch (\Throwable $e) {
            return [false, $e->getMessage(), null];
        }

        return [true, null, $minute->fresh(['participants', 'tasks'])];
    }

    public function syncParticipants(Minute $minute, array $participants): void
    {
        $minute->participants()->delete();
        foreach ($participants as $row) {
            if (empty($row['user_id'])) {
                continue;
            }
            MinuteParticipant::create([
                'minute_id'         => $minute->id,
                'user_id'           => $row['user_id'],
                'role'              => $row['role'] ?? null,
                'attendance_status' => $row['attendance_status'] ?? null,
            ]);
        }
    }

    /**
     * Copia tareas no completadas/no canceladas de la minuta previa,
     * conservando traza mediante parent_task_id.
     */
    public function copyPendingTasksFromPrevious(Minute $minute): int
    {
        $previous = Minute::where('id', '<>', $minute->id)
            ->where('is_active', true)
            ->where('meeting_date', '<=', $minute->meeting_date)
            ->orderByDesc('meeting_date')
            ->orderByDesc('id')
            ->first();

        if (!$previous) {
            return 0;
        }

        $openTasks = $previous->tasks()
            ->whereNotIn('status', [
                MinuteTaskStatusEnum::COMPLETED->value,
                MinuteTaskStatusEnum::CANCELED->value,
            ])
            ->orderBy('position')
            ->get();

        $position = 0;
        foreach ($openTasks as $task) {
            MinuteTask::create([
                'minute_id'      => $minute->id,
                'parent_task_id' => $task->id,
                'title'          => $task->title,
                'description'    => $task->description,
                'assigned_to'    => $task->assigned_to,
                'status'         => $task->status,
                'priority'       => $task->priority,
                'due_date'       => $task->due_date,
                'progress'       => $task->progress,
                'comments'       => null,
                'created_by'     => auth()->id() ?? $task->created_by,
                'position'       => $position++,
            ]);
        }

        return $openTasks->count();
    }

    /**
     * Guarda una nueva tarea dentro de una minuta.
     */
    public function storeTask(Minute $minute, Request $request): array
    {
        try {
            $task = DB::transaction(function () use ($minute, $request) {
                $position = (int) $minute->tasks()->max('position') + 1;

                return MinuteTask::create([
                    'minute_id'   => $minute->id,
                    'title'       => $request->title,
                    'description' => $request->description,
                    'assigned_to' => $request->assigned_to,
                    'status'      => $request->status   ?? MinuteTaskStatusEnum::PENDING->value,
                    'priority'    => $request->priority ?? MinuteTaskPriorityEnum::MEDIUM->value,
                    'due_date'    => $request->due_date,
                    'progress'    => (int) ($request->progress ?? 0),
                    'comments'    => $request->comments,
                    'created_by'  => auth()->id(),
                    'position'    => $position,
                ]);
            });
        } catch (\Throwable $e) {
            return [false, $e->getMessage(), null];
        }

        return [true, null, $task];
    }

    /**
     * Actualiza una tarea y registra historial en campos rastreados.
     */
    public function updateTask(MinuteTask $task, Request $request): array
    {
        $tracked = MinuteTaskUpdateFieldEnum::values();

        try {
            DB::transaction(function () use ($task, $request, $tracked) {
                $original = $task->only($tracked);

                $payload = array_filter([
                    'title'       => $request->title,
                    'description' => $request->description,
                    'assigned_to' => $request->assigned_to,
                    'status'      => $request->status,
                    'priority'    => $request->priority,
                    'due_date'    => $request->due_date,
                    'progress'    => $request->has('progress') ? (int) $request->progress : null,
                    'comments'    => $request->comments,
                ], fn ($v) => !is_null($v));

                if (isset($payload['status'])
                    && $payload['status'] === MinuteTaskStatusEnum::COMPLETED->value
                    && empty($task->completed_at)) {
                    $payload['completed_at'] = now();
                    $payload['progress'] = 100;
                }

                $task->update($payload);

                // Solo registramos auditoria cuando realmente hubo cambio de valor.
                foreach ($tracked as $field) {
                    $old = $original[$field] ?? null;
                    $new = $task->getAttribute($field);
                    if ((string) $old !== (string) $new) {
                        MinuteTaskUpdate::create([
                            'minute_task_id' => $task->id,
                            'user_id'        => auth()->id(),
                            'field'          => $field,
                            'old_value'      => is_null($old) ? null : (string) $old,
                            'new_value'      => is_null($new) ? null : (string) $new,
                        ]);
                    }
                }
            });
        } catch (\Throwable $e) {
            return [false, $e->getMessage(), null];
        }

        return [true, null, $task->fresh()];
    }

    public function destroyTask(MinuteTask $task): array
    {
        try {
            $task->delete();
        } catch (\Throwable $e) {
            return [false, $e->getMessage()];
        }
        return [true, null];
    }

    /**
     * Construye metricas generales de una minuta.
     */
    public function metrics(Minute $minute): array
    {
        $tasks = $minute->tasks()->get();

        $total     = $tasks->count();
        $pending   = $tasks->whereIn('status', [
            MinuteTaskStatusEnum::PENDING->value,
            MinuteTaskStatusEnum::IN_PROGRESS->value,
        ])->count();
        $completed = $tasks->where('status', MinuteTaskStatusEnum::COMPLETED->value)->count();
        $canceled  = $tasks->where('status', MinuteTaskStatusEnum::CANCELED->value)->count();

        $today = Carbon::today();
        $overdue = $tasks->filter(function ($t) use ($today) {
            return $t->due_date
                && $t->due_date->lt($today)
                && !in_array($t->status, [
                    MinuteTaskStatusEnum::COMPLETED->value,
                    MinuteTaskStatusEnum::CANCELED->value,
                ]);
        })->count();

        $compliance = $total > 0 ? round(($completed / $total) * 100, 1) : 0;

        $byAssignee = $tasks
            ->groupBy('assigned_to')
            ->map(function ($items) {
                $first = $items->first();
                return [
                    'name'      => optional($first->assignee)->name ?? 'Sin asignar',
                    'total'     => $items->count(),
                    'completed' => $items->where('status', MinuteTaskStatusEnum::COMPLETED->value)->count(),
                ];
            })
            ->values()
            ->all();

        return [
            'total'      => $total,
            'pending'    => $pending,
            'completed'  => $completed,
            'canceled'   => $canceled,
            'overdue'    => $overdue,
            'compliance' => $compliance,
            'byAssignee' => $byAssignee,
        ];
    }

    /**
     * Serie semanal de cumplimiento para las ultimas N semanas.
     */
    public function weeklyCompliance(int $weeks = 8): array
    {
        $start = Carbon::today()->subWeeks($weeks - 1)->startOfWeek();

        $minutes = Minute::with('tasks')
            ->where('is_active', true)
            ->where('meeting_date', '>=', $start->toDateString())
            ->get();

        $buckets = [];
        for ($i = 0; $i < $weeks; $i++) {
            $weekStart = $start->copy()->addWeeks($i);
            $buckets[$weekStart->format('Y-\WW')] = [
                'label'      => $weekStart->format('d/m'),
                'completed'  => 0,
                'total'      => 0,
                'compliance' => 0,
            ];
        }

        foreach ($minutes as $minute) {
            $key = Carbon::parse($minute->meeting_date)->format('Y-\WW');
            if (!isset($buckets[$key])) {
                continue;
            }
            foreach ($minute->tasks as $task) {
                $buckets[$key]['total']++;
                if ($task->status === MinuteTaskStatusEnum::COMPLETED->value) {
                    $buckets[$key]['completed']++;
                }
            }
        }

        foreach ($buckets as $k => $b) {
            $buckets[$k]['compliance'] = $b['total'] > 0
                ? round(($b['completed'] / $b['total']) * 100, 1)
                : 0;
        }

        return array_values($buckets);
    }

    /**
     * Reporte mensual por usuario: carga de trabajo, completadas y cumplimiento.
     *
     * Nota: se deduplica por tarea logica (cadenas de herencia) para evitar
     * contar varias veces la misma tarea en minutas consecutivas.
     */
    public function monthlyUserReport(int $year, int $month, ?int $userId = null): array
    {
        $from = Carbon::create($year, $month, 1)->startOfMonth();
        $to = $from->copy()->endOfMonth();

        $tasksQuery = MinuteTask::query()
            ->with(['assignee:id,name', 'minute:id,title'])
            ->whereHas('minute', function ($q) use ($from, $to) {
                $q->where('is_active', true)
                    ->whereBetween('meeting_date', [$from->toDateString(), $to->toDateString()]);
            });

        if (!is_null($userId)) {
            $tasksQuery->where('assigned_to', $userId);
        }

        $tasks = $tasksQuery->get();

        // Mapa id_tarea -> id_tarea_raiz para unificar tareas heredadas.
        $logicalTaskMap = $this->buildLogicalTaskMap($tasks->pluck('id')->all());
        $tasks = $tasks->map(function ($task) use ($logicalTaskMap) {
            $task->logical_task_id = $logicalTaskMap[$task->id] ?? (int) $task->id;
            return $task;
        });

        $updatesQuery = MinuteTaskUpdate::query()
            ->select('minute_task_updates.*', 'minute_tasks.assigned_to as assigned_to')
            ->join('minute_tasks', 'minute_tasks.id', '=', 'minute_task_updates.minute_task_id')
            ->join('minutes', 'minutes.id', '=', 'minute_tasks.minute_id')
            ->where('minutes.is_active', true)
            ->whereBetween('minute_task_updates.created_at', [$from->copy()->startOfDay(), $to->copy()->endOfDay()])
            ->whereBetween('minutes.meeting_date', [$from->toDateString(), $to->toDateString()]);

        if (!is_null($userId)) {
            $updatesQuery->where('minute_tasks.assigned_to', $userId);
        }

        $updates = $updatesQuery->get();

        $groupedTasks = $tasks->groupBy(function ($task) {
            return $task->assigned_to ?: 0;
        });

        $groupedUpdates = $updates->groupBy(function ($update) {
            return (int) ($update->assigned_to ?? 0);
        });

        $rows = $groupedTasks->map(function ($userTasks, $assigneeId) use ($groupedUpdates, $from, $to) {
            $userUpdates = $groupedUpdates->get((int) $assigneeId, collect());

            // Se toma la ultima version por cadena logica para contar "una sola tarea".
            $logicalTasks = $userTasks
                ->sortByDesc('id')
                ->unique('logical_task_id')
                ->values();

            $total = $logicalTasks->count();
            $completed = $userTasks->filter(function ($task) {
                return !is_null($task->completed_at);
            })->filter(function ($task) use ($from, $to) {
                return Carbon::parse($task->completed_at)->betweenIncluded($from->copy()->startOfDay(), $to->copy()->endOfDay());
            })->unique('logical_task_id')->count();

            
            $firstTask = $logicalTasks->first();
            $name = optional($firstTask->assignee)->name ?? 'Sin asignar';

            return [
                'user_id' => (int) $assigneeId,
                'name' => $name,
                'total_tasks' => $total,
                'completed_tasks' => $completed,
                'pending_tasks' => max(0, $total - $completed),
                'compliance' => $total > 0 ? round(($completed / $total) * 100, 1) : 0,
            ];
        })->sortByDesc('completed_tasks')->values()->all();

        $labels = array_column($rows, 'name');
        $completedSeries = array_column($rows, 'completed_tasks');
        $complianceSeries = array_column($rows, 'compliance');

        // Tabla de completadas del periodo, tambien deduplicada por cadena logica.
        $completedTasks = $tasks->filter(function ($task) use ($from, $to) {
            if (is_null($task->completed_at)) {
                return false;
            }
            return Carbon::parse($task->completed_at)->betweenIncluded($from->copy()->startOfDay(), $to->copy()->endOfDay());
        })->sortByDesc('completed_at')
            ->unique('logical_task_id')
            ->values()
            ->map(function ($task) {
            return [
                'minute_id' => $task->minute_id,
                'task_id' => $task->id,
                'logical_task_id' => $task->logical_task_id,
                'task_title' => $task->title,
                'minute_title' => optional($task->minute)->title,
                'assignee_name' => optional($task->assignee)->name ?? 'Sin asignar',
                'completed_at' => Carbon::parse($task->completed_at)->format('d/m/Y H:i'),
                'status' => $task->status,
                'progress' => (int) $task->progress,
            ];
        })->values()->all();

        return [
            'from' => $from,
            'to' => $to,
            'rows' => $rows,
            'chart' => [
                'labels' => $labels,
                'completed' => $completedSeries,
                'compliance' => $complianceSeries,
            ],
            'totals' => [
                'users' => count($rows),
                'tasks' => array_sum(array_column($rows, 'total_tasks')),
                'completed' => array_sum($completedSeries),
            ],
            'completed_tasks' => $completedTasks,
        ];
    }

    /**
     * Resuelve un id logico estable (raiz) para cadenas de tareas heredadas.
     */
    private function buildLogicalTaskMap(array $taskIds): array
    {
        $taskIds = array_values(array_unique(array_map('intval', $taskIds)));
        if (empty($taskIds)) {
            return [];
        }

        $parentById = [];
        $toFetch = $taskIds;

        while (!empty($toFetch)) {
            $rows = MinuteTask::query()
                ->select('id', 'parent_task_id')
                ->whereIn('id', $toFetch)
                ->get();

            $toFetch = [];
            foreach ($rows as $row) {
                $id = (int) $row->id;
                if (array_key_exists($id, $parentById)) {
                    continue;
                }

                $parentById[$id] = is_null($row->parent_task_id) ? null : (int) $row->parent_task_id;

                if (!is_null($parentById[$id]) && !array_key_exists($parentById[$id], $parentById)) {
                    $toFetch[] = $parentById[$id];
                }
            }

            $toFetch = array_values(array_unique($toFetch));
        }

        $cache = [];
        $logicalTaskMap = [];
        foreach ($taskIds as $taskId) {
            $logicalTaskMap[$taskId] = $this->resolveLogicalTaskRoot($taskId, $parentById, $cache);
        }

        return $logicalTaskMap;
    }

    /**
     * Recorre parent_task_id hacia arriba hasta encontrar la raiz.
     */
    private function resolveLogicalTaskRoot(int $taskId, array $parentById, array &$cache): int
    {
        if (isset($cache[$taskId])) {
            return $cache[$taskId];
        }

        $current = $taskId;
        $visited = [];

        while (array_key_exists($current, $parentById) && !is_null($parentById[$current])) {
            if (isset($visited[$current])) {
                break;
            }

            $visited[$current] = true;
            $parent = (int) $parentById[$current];

            if (!array_key_exists($parent, $parentById)) {
                break;
            }

            if (isset($cache[$parent])) {
                $current = $cache[$parent];
                break;
            }

            $current = $parent;
        }

        $root = $current;
        $cache[$taskId] = $root;
        foreach (array_keys($visited) as $visitedId) {
            $cache[(int) $visitedId] = $root;
        }

        return $root;
    }

    /**
     * Timeline detallado de una tarea (cambios de status/avance/responsable/prioridad).
     */
    public function taskHistory(MinuteTask $task): array
    {
        $task->load([
            'minute:id,title,meeting_date',
            'assignee:id,name',
            'updates' => function ($q) {
                $q->with('user:id,name')->orderBy('created_at');
            },
        ]);

        $timeline = $task->updates->map(function ($update) {
            $fieldValue = $update->field instanceof MinuteTaskUpdateFieldEnum
                ? $update->field->value
                : (is_null($update->field) ? null : (string) $update->field);

            return [
                'when' => Carbon::parse($update->created_at)->format('d/m/Y H:i'),
                'user' => optional($update->user)->name ?? 'Sistema',
                'field' => $fieldValue,
                'field_label' => MinuteTaskUpdateFieldEnum::labelFor($fieldValue),
                'old' => $update->old_value,
                'new' => $update->new_value,
            ];
        })->all();

        $monthlyProgress = collect($task->updates)
            ->filter(function ($update) {
                if ($update->field instanceof MinuteTaskUpdateFieldEnum) {
                    return $update->field === MinuteTaskUpdateFieldEnum::PROGRESS;
                }

                return (string) $update->field === MinuteTaskUpdateFieldEnum::PROGRESS->value;
            })
            ->groupBy(function ($update) {
                return Carbon::parse($update->created_at)->format('Y-m');
            })
            ->map(function ($items, $monthKey) {
                $last = $items->sortBy('created_at')->last();
                return [
                    'month' => $monthKey,
                    'label' => Carbon::createFromFormat('Y-m', $monthKey)->format('m/Y'),
                    'progress' => (int) ($last->new_value ?? 0),
                ];
            })
            ->values()
            ->all();

        return [
            'task' => $task,
            'timeline' => $timeline,
            'monthly_progress' => $monthlyProgress,
        ];
    }

    /**
     * Genera el PDF de una minuta.
     */
    public function exportPdf(Minute $minute)
    {
        // Cargamos relaciones necesarias para evitar consultas N+1 en la vista PDF.
        $minute->load(['creator', 'participants.user', 'tasks.assignee', 'tasks.updates.user']);
        $metrics = $this->metrics($minute);

        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        // Seccion global: tareas terminadas en el mes actual (todas las minutas activas).
        $completedCurrentMonth = MinuteTask::query()
            ->with(['assignee:id,name', 'minute:id,title'])
            ->whereNotNull('completed_at')
            ->whereBetween('completed_at', [$monthStart->copy()->startOfDay(), $monthEnd->copy()->endOfDay()])
            ->whereHas('minute', function ($q) {
                $q->where('is_active', true);
            })
            ->orderByDesc('completed_at')
            ->get();

        $pdf = Pdf::loadView('minutes.pdf.layout', [
            'minute'  => $minute,
            'metrics' => $metrics,
            'completedCurrentMonth' => $completedCurrentMonth,
        ])->setPaper('letter', 'portrait');

        return $pdf->stream('minuta_' . $minute->id . '.pdf');
    }
}
