<form action="{{ route('f_flux_reports.exportAdminReport') }}">
    <p><b>REPORTE COMPLETO ADMINISTRATIVO</b></p>
    <p>Este reporte muestra, por rango de fechas, todos los ingresos y egresos con el detalle de cada clasificación. Además, incluye:</p>
    <ol>
        <li>Saldos iniciales y finales por día entre todas las cuentas.</li>
        <li>Totales diarios de ingresos y egresos.</li>
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
        <div class="col-2">
            <button class="btn btn-success">Descargar Excel</a>
        </div>
    </div>
</form>