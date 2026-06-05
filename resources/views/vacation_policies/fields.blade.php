<div class="row mb-3">
    <div class="col-md-4 mb-2">
        @include("components.custom.forms.input", [
            "id" => "years_from",
            "name" => "years_from",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "De años...",
            "label" => "De años",
            "required" => true,
            "value" => isset($vacationPolicy) ? $vacationPolicy->years_from :  old("years_from"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>
    <div class="col-md-4 mb-2">
        @include("components.custom.forms.input", [
            "id" => "years_to",
            "name" => "years_to",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "A años...",
            "label" => "A años",
            "required" => true,
            "value" => isset($vacationPolicy) ? $vacationPolicy->years_to :  old("years_to"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>
    <div class="col-md-4 mb-2">
        @include("components.custom.forms.input", [
            "id" => "days",
            "name" => "days",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Días...",
            "label" => "Días",
            "required" => true,
            "value" => isset($vacationPolicy) ? $vacationPolicy->days :  old("days"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>
    <div class="col-md-4 mb-2">
        @include("components.custom.forms.input", [
            "id" => "advance_days",
            "name" => "advance_days",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Días en avance...",
            "label" => "Días en avance",
            "required" => true,
            "value" => isset($vacationPolicy) ? $vacationPolicy->advance_days :  old("days"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>
    <div class="col-md-4 mb-2">
        @include("components.custom.forms.input", [
            "id" => "applicable_month_range",
            "name" => "applicable_month_range",
            "type" => "number",
            "min" => 0,
            "max" => 100,
            "placeholder" => "Rango de meses aplicable...",
            "label" => "Rango de meses aplicable",
            "required" => true,
            "value" => isset($vacationPolicy) ? $vacationPolicy->applicable_month_range :  old("applicable_month_range"),
            "invalid_feedback" => "El campo es requerido",
        ])
    </div>

</div>
