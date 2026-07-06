<?php

namespace App\Http\Controllers;

use App\Http\Requests\MinuteTaskRequest;
use App\Models\Minute;
use App\Models\MinuteTask;
use App\Services\MinuteService;
use Illuminate\Http\Request;

class MinuteTaskController extends Controller
{
    protected MinuteService $service;

    public function __construct(MinuteService $service)
    {
        $this->service = $service;
    }

    public function store(MinuteTaskRequest $request, Minute $minute)
    {
        list($status, $error, $task) = $this->service->storeTask($minute, $request);
        $message = $status ? "Tarea agregada correctamente" : ('Error al guardar la tarea: ' . e($error));

        if ($request->expectsJson()) {
            return response()->json(['status' => $status, 'message' => $message, 'data' => $task]);
        }

        return $this->getResponse($status, $message, $task, redirect()->route('minutes.show', $minute->id));
    }

    public function update(MinuteTaskRequest $request, Minute $minute, MinuteTask $task)
    {
        abort_if($task->minute_id !== $minute->id, 404);

        list($status, $error, $task) = $this->service->updateTask($task, $request);
        $message = $status ? "Tarea actualizada correctamente" : ('Error al actualizar la tarea: ' . e($error));

        if ($request->expectsJson()) {
            return response()->json(['status' => $status, 'message' => $message, 'data' => $task]);
        }

        return $this->getResponse($status, $message, $task, redirect()->route('minutes.show', $minute->id));
    }

    public function destroy(Request $request, Minute $minute, MinuteTask $task)
    {
        abort_if($task->minute_id !== $minute->id, 404);

        list($status, $error) = $this->service->destroyTask($task);
        $message = $status ? "Tarea eliminada correctamente" : ('Error al eliminar la tarea: ' . e($error));

        if ($request->expectsJson()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return $this->getResponse($status, $message, null, redirect()->route('minutes.show', $minute->id));
    }
}
