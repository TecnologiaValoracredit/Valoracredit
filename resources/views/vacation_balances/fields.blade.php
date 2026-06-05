<div class="row mb-3">
    <div class="text-center mb-2">
        <label for="user"><strong>Usuario: </strong></label>
        <span id="user">{{ $vacationBalance->user->name ?? "No especificados "}}</span>
    </div>
    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "active_years",
            "name" => "active_years",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Años activo...",
            "label" => "Años activo",
            "required" => true,
            "value" => isset($vacationBalance) ? $vacationBalance->active_years :  old("active_years"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>

    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "days_assigned",
            "name" => "days_assigned",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Días asignados...",
            "label" => "Días asignados",
            "required" => true,
            "value" => isset($vacationBalance) ? $vacationBalance->days_assigned :  old("days_assigned"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>

    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "days_remaining",
            "name" => "days_remaining",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Días restantes...",
            "label" => "Días restantes",
            "required" => true,
            "value" => isset($vacationBalance) ? $vacationBalance->days_remaining :  old("days_remaining"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>

    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "days_used",
            "name" => "days_used",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Días usados...",
            "label" => "Días usados",
            "required" => true,
            "value" => isset($vacationBalance) ? $vacationBalance->days_used :  old("days_used"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>

    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "advance_days_available",
            "name" => "advance_days_available",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Días en avance restantes...",
            "label" => "Días en avance restantes",
            "required" => true,
            "value" => isset($vacationBalance) ? $vacationBalance->advance_days_available :  old("advance_days_available"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>

    <div class="col-md-6 mb-2">
        @include("components.custom.forms.input", [
            "id" => "advance_days_used",
            "name" => "advance_days_used",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Días en avance usados...",
            "label" => "Días en avance usados",
            "required" => true,
            "value" => isset($vacationBalance) ? $vacationBalance->advance_days_used :  old("advance_days_used"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>
</div>
