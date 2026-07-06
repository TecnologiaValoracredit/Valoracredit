<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MinuteRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $normalizeTime = static function ($value) {
            if (!$value) {
                return $value;
            }

            // Accept values like HH:MM:SS from DB/browser and normalize to HH:MM.
            return preg_match('/^\d{2}:\d{2}:\d{2}$/', (string) $value)
                ? substr((string) $value, 0, 5)
                : $value;
        };

        $this->merge([
            'start_time' => $normalizeTime($this->input('start_time')),
            'end_time'   => $normalizeTime($this->input('end_time')),
        ]);
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'                            => 'required|string|max:255',
            'meeting_date'                     => 'required|date',
            'start_time'                       => 'nullable|date_format:H:i',
            'end_time'                         => 'nullable|date_format:H:i|after_or_equal:start_time',
            'notes'                            => 'nullable|string',
            'status'                           => 'nullable|string|in:open,closed,canceled',
            'participants'                     => 'nullable|array',
            'participants.*.user_id'           => 'required_with:participants|integer|exists:users,id',
            'participants.*.role'              => 'nullable|string|max:80',
            'participants.*.attendance_status' => 'nullable|string|in:present,absent,excused',
        ];
    }

    public function attributes()
    {
        return [
            'title'        => 'Título',
            'meeting_date' => 'Fecha de reunión',
            'start_time'   => 'Hora inicio',
            'end_time'     => 'Hora fin',
            'notes'        => 'Notas',
        ];
    }

    public function messages()
    {
        return [
            'end_time.after_or_equal' => 'La Hora fin debe ser mayor o igual que la Hora inicio.',
        ];
    }
}
