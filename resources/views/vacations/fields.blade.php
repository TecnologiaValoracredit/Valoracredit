<div class="row mt-3">
    <div class="col-md-6 mb-2 p-3 bg-gradient bg-light">
        <div>
            <label for="user"><strong>Nombre de usuario: </strong></label>
            <span id="user">{{ auth()->user()->name ?? "No especificado "}}</span>
        </div>
        <div>
            <label for="available_days"><strong>Días disponibles: </strong></label>
            <span id="available_days">{{ auth()->user()->vacationBalance->days_remaining ?? "No especificados "}}</span>
        </div>
        <div>
            <label for="advance_available_days"><strong>Días en avance disponibles: </strong></label>
            <span id="advance_available_days">{{ auth()->user()->vacationBalance->advance_days_available ?? "No especificados "}}</span>
        </div>
        <div>
            <label for="boss"><strong>Jefe Inmediato: </strong></label>
            <span id="boss">{{ auth()->user()->boss->name ?? "No especificado "}}</span>
        </div>
        <div>
            <label for="hr_user"><strong>RH: </strong></label>
            <span id="hr_user">{{ $hrUser->name ?? "No especificado "}}</span>
        </div>
    </div>
    
    <div class="col-md-6 mb-2 d-flex justify-content-end align-items-start">
        <div class="btn btn-primary">Ver políica de vacaciones (PDF)</div>
    </div>

    <div class="col-md-12 bg-gradient bg-light">
        <div class="col-md-6">
            @include("components.custom.forms.input", [
                "id" => "total_days",
                "name" => "total_days",
                "type" => "number",
                "placeholder" => "Ejemplo: 2",
                "label" => "Días a tomar:",
                "required" => true,
                "min" => 1,
                "value" => isset($vacation) ? $vacation->total_days :  old("total_days"),
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    </div>

    <div class="col-md-12 bg-gradient bg-light">
        <div class="mt-3 text-center"><label for="dates"><b>Fechas</b></label></div>
    </div>
    <div class="col-md-12 bg-gradient bg-light dates-container d-flex gap-2 flex-wrap justify-content-around">
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        @include("components.custom.forms.textarea", [
            "id" => "reason",
            "name" => "reason",
            "type" => "textarea",
            "placeholder" => "Razón...",
            "label" => "Razón",
            "value" => isset($vacation) ? $vacation->reason :  old("reason"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col-md-6">
        @include("components.custom.forms.textarea", [
            "id" => "notes",
            "name" => "notes",
            "type" => "textarea",
            "placeholder" => "Notas...",
            "label" => "Notas",
            "value" => isset($vacation) ? $vacation->notes :  old("notes"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>

@if (isset($vacation))
<div id="vacation-dates" class="d-none">
    @foreach ($vacation->dates as $key => $date)
    <input type="hidden" value="{{ $date->date }}">
    @endforeach
</div>
@endif
