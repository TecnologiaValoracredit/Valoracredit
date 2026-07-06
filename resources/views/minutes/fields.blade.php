<div class="row">
    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "title",
            "name" => "title",
            "type" => "text",
            "placeholder" => "Título de la minuta...",
            "label" => "Título",
            "required" => true,
            "value" => isset($minute) ? $minute->title : old("title"),
            "invalid_feedback" => "El título es requerido"
        ])
    </div>
    <div class="col-md-3 mb-2">
        @include("components.custom.forms.input", [
            "id" => "meeting_date",
            "name" => "meeting_date",
            "type" => "date",
            "label" => "Fecha de reunión",
            "required" => true,
            "value" => isset($minute) ? optional($minute->meeting_date)->format('Y-m-d') : old("meeting_date", date('Y-m-d')),
            "invalid_feedback" => "La fecha es requerida"
        ])
    </div>
    <div class="col-md-3 mb-2">
        @if(isset($statuses) && isset($minute))
            @include("components.custom.forms.input-select", [
                "id" => "status",
                "name" => "status",
                "label" => "Estatus",
                "elements" => $statuses,
                "value" => $minute->status,
            ])
        @endif
    </div>
    <div class="col-md-3 mb-2">
        @include("components.custom.forms.input", [
            "id" => "start_time",
            "name" => "start_time",
            "type" => "time",
            "label" => "Hora inicio",
            "value" => old("start_time", isset($minute) && $minute->start_time ? substr((string) $minute->start_time, 0, 5) : null),
        ])
    </div>
    <div class="col-md-3 mb-2">
        @include("components.custom.forms.input", [
            "id" => "end_time",
            "name" => "end_time",
            "type" => "time",
            "label" => "Hora fin",
            "value" => old("end_time", isset($minute) && $minute->end_time ? substr((string) $minute->end_time, 0, 5) : null),
        ])
    </div>
    <div class="col-12 mb-2">
        @include("components.custom.forms.textarea", [
            "id" => "notes",
            "name" => "notes",
            "label" => "Notas / Agenda",
            "placeholder" => "Notas generales de la reunión...",
            "value" => isset($minute) ? $minute->notes : old("notes"),
        ])
    </div>
</div>

<hr>

<h6 class="mb-2">Participantes</h6>
<div id="participants-wrapper">
    @php
        $rows = isset($minute) ? $minute->participants : collect();
    @endphp
    @forelse($rows as $i => $p)
        <div class="row align-items-end mb-2 participant-row">
            <div class="col-md-5">
                @include("components.custom.forms.input-select", [
                    "id" => "participants_user_$i",
                    "name" => "participants[$i][user_id]",
                    "label" => "Usuario",
                    "elements" => $users,
                    "value" => $p->user_id,
                    "placeholder" => "Seleccione un usuario...",
                ])
            </div>
            <div class="col-md-3">
                @include("components.custom.forms.input-select", [
                    "id" => "participants_attendance_$i",
                    "name" => "participants[$i][attendance_status]",
                    "label" => "Asistencia",
                    "elements" => ['present' => 'Presente', 'absent' => 'Ausente', 'excused' => 'Justificado'],
                    "value" => $p->attendance_status,
                    "placeholder" => "Seleccione...",
                ])
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger remove-participant w-100">x</button>
            </div>
        </div>
    @empty
    @endforelse
</div>
<button type="button" id="add-participant" class="btn btn-outline-primary btn-sm mt-2">
    + Agregar participante
</button>
<script type="application/json" id="minute-users-data">@json($users)</script>
