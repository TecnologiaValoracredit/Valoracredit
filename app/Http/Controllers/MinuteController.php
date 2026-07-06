<?php

namespace App\Http\Controllers;

use App\DataTables\MinuteDataTable;
use App\Enums\MinuteStatusEnum;
use App\Enums\MinuteTaskPriorityEnum;
use App\Enums\MinuteTaskStatusEnum;
use App\Http\Requests\MinuteRequest;
use App\Models\Minute;
use App\Models\MinuteTask;
use App\Models\User;
use App\Services\MinuteService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MinuteController extends Controller
{
    protected MinuteService $service;

    public function __construct(MinuteService $service)
    {
        $this->service = $service;
    }

    public function index(MinuteDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("minutes.create");
        return $dataTable->render('minutes.index', compact("allowAdd"));
    }

    public function create()
    {
        $users = User::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        return view('minutes.create', compact('users'));
    }

    public function store(MinuteRequest $request)
    {
        list($status, $error, $minute) = $this->service->store($request);
        $message = "Minuta creada correctamente";

        if (!$status) {
            $message = 'Error al crear la minuta. <br><span class="text-danger">' . e($error) . '</span>';
        }

        return $this->getResponse($status, $message, $minute);
    }

    public function show(Minute $minute)
    {
        $minute->load([
            'creator',
            'participants.user',
            'tasks.assignee',
            'tasks.updates.user',
        ]);

        $users      = User::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        $metrics    = $this->service->metrics($minute);
        $weekly     = $this->service->weeklyCompliance();
        $statuses   = MinuteTaskStatusEnum::labels();
        $priorities = MinuteTaskPriorityEnum::labels();

        return view('minutes.show', compact('minute', 'users', 'metrics', 'weekly', 'statuses', 'priorities'));
    }

    public function edit(Minute $minute)
    {
        $minute->load('participants.user');
        $users    = User::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        $statuses = MinuteStatusEnum::labels();

        return view('minutes.edit', compact('minute', 'users', 'statuses'));
    }

    public function update(MinuteRequest $request, Minute $minute)
    {
        list($status, $error, $minute) = $this->service->update($request, $minute);
        $message = "Minuta modificada correctamente";

        if (!$status) {
            $message = 'Error al modificar la minuta. <br><span class="text-danger">' . e($error) . '</span>';
        }

        return $this->getResponse($status, $message, $minute);
    }

    public function destroy(Minute $minute)
    {
        $status = true;
        try {
            $minute->update(['is_active' => false]);
            $message = "Minuta desactivada correctamente";
        } catch (QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'minutes');
        }

        return $this->getResponse($status, $message);
    }

    public function exportPdf(Minute $minute)
    {
        return $this->service->exportPdf($minute);
    }

    public function monthlyReport(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);
        $userId = $request->filled('user_id') ? (int) $request->input('user_id') : null;

        $month = max(1, min(12, $month));
        $year = max(2020, min(2100, $year));

        $users = User::where('is_active', true)->orderBy('name')->pluck('name', 'id');
        $report = $this->service->monthlyUserReport($year, $month, $userId);

        return view('minutes.reports.monthly', compact('report', 'users', 'year', 'month', 'userId'));
    }

    public function taskHistory(Minute $minute, MinuteTask $task)
    {
        abort_if($task->minute_id !== $minute->id, 404);

        $history = $this->service->taskHistory($task);

        return view('minutes.reports.task-history', compact('minute', 'task', 'history'));
    }
}
