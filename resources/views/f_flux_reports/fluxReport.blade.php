<form action="{{ route('f_flux_reports.exportFluxReport') }}">
    <p><b>REPORTE DE FLUJO</b></p>
    <p>Este es el reporte de flujos, en el que se muestra todos los flujos dentro del rango de fechas, y si se desea por egreso e ingreso</p>
    <ol>
        <li>Flujos por ingreso y egreso.</li>
        <li>Este reporte incluye, fecha, beneficiario, concepto, tipo de movimiento, monto, clasificación, 
            clasificación cobro, notas administrativas, notas de cartera, y el estado 
        </li>
        <li>Porcentaje de participación de cada clasificación en el total de ingresos o egresos.</li>
    </ol>
    <p class="text-danger">Limitaciones y considereciones:</p>
    <ol class="text-danger">
        <li>Evitar rangos de fechas muy extensos (recomendado máximo 6 meses)</li>
        <li>El tiempo de espera para generar el reporte varía dependiendo del rango de fechas.</li>
    </ol>
    <div class="row">
        <div class="col-5">
            @include("components.custom.forms.input-inline", [
                "id" => "start_date",
                "name" => "start_date",
                "type" => "date",
                "label" => "Fecha inicial",
                "required" => true,
                "value" => $startDate,
                "invalid_feedback" => "El campo es requerido",
            ])
        </div>
        <div class="col-5">
            @include("components.custom.forms.input-inline", [
                "id" => "end_date",
                "name" => "end_date",
                "type" => "date",
                "label" => "Fecha final",
                "required" => true,
                "value" => $endDate,
                "invalid_feedback" => "El campo es requerido",
            ])                            </div>

            <div class="col-5">
            @include("components.custom.forms.input-inline-select", [
                        "id" => "f_movement_type",
                        "name" => "f_movement_type",
                        "label" => "Tipo de movimiento",
                        "type" => "select",
                        "elements" => $f_movement_types,  
                        "class" => "col-6",
                        "value" => 0
                    ])                            </div>

        <div class="col-2">
            <button class="btn btn-success">Descargar Excel</a>
        </div>
    </div>
</form>