<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MinuteTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|integer|exists:users,id',
            'status'      => 'nullable|string|in:pending,in_progress,completed,canceled',
            'priority'    => 'nullable|string|in:low,medium,high,urgent',
            'due_date'    => 'nullable|date',
            'progress'    => 'nullable|integer|min:0|max:100',
            'comments'    => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'title'       => 'Título',
            'description' => 'Descripción',
            'assigned_to' => 'Responsable',
            'status'      => 'Estatus',
            'priority'    => 'Prioridad',
            'due_date'    => 'Fecha compromiso',
            'progress'    => 'Avance',
            'comments'    => 'Comentarios',
        ];
    }
}
