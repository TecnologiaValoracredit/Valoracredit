<form id="fixed_expense_form">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            @include("components.custom.forms.input-select", [
                "id" => "fixed_expense_id",
                "name" => "fixed_expense_id",
                "elements" => $fixed_expenses,
                "placeholder" => "Seleccione un Gasto recurrente...",
                "value" => old("fixed_expense_id"),
                "label" => "Gasto recurrente",
            ])
        </div>
    </div>
</form>