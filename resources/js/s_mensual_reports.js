$(function () {
    // Suponiendo que la tabla se llama 's_mensual_reports-table' y tiene datos numéricos

    function calcularTotales() {
        const table = window.LaravelDataTables["s_mensual_reports-table"];
        const data = table.rows({ search: 'applied' }).data();
        const lastRow = table.row(':last').data();

        // Verificar si ya existe la fila de totales
        if (lastRow && lastRow.institution_name === "TOTAL GENERAL") {
            return; // No agregar otra fila de totales
        }

        // Inicializar los totales
        var totals = {
            institution_name: "TOTAL GENERAL",
            total_monthly: 0,
            total_sales: 0,
            percentage_of_total: "100%", // Total siempre será el 100%
        };

        // Recorrer los datos y sumar los valores para el mes actual
        data.each(function (row) {
            totals.total_monthly += parseFloat(row.total_monthly.replace(/,/g, "")) || 0; // Total mensual
            totals.total_sales += parseInt(row.total_sales.replace(/,/g, ""), 10) || 0; // Total de ventas
        });

        // Formatear los totales para que coincidan con el formato de la tabla
        totals.total_monthly = totals.total_monthly.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        totals.total_sales = totals.total_sales.toLocaleString();

        // Agregar la fila de totales al final de la tabla
        table.row.add(totals).draw(false);
    }

    // Ejecutar la función al inicializar o redibujar la tabla
    $('#s_mensual_reports-table').on('init.dt draw.dt', function () {
        calcularTotales();
    });
});
