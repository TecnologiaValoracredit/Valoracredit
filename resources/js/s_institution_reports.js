$(function () {
    // Suponiendo que la tabla tiene un ID `s_institution_reports-table`
    function agregarFilaTotal() {
        const table = $('#s_institution_reports-table').DataTable();
        const data = table.rows({ search: 'applied' }).data(); // Obtiene los datos visibles en la tabla

        // Inicializar el total general
        let totalGeneral = 0;

        // Calcular la suma total
        data.each(function (row) {
            const totalMensual = parseFloat(row.total.replace(/,/g, "")) || 0; // Convertir string a número
            totalGeneral += totalMensual;
        });

        // Verificar si ya existe la fila de totales
        const lastRow = table.row(':last').data();
        if (lastRow && lastRow.month === "TOTAL GENERAL") {
            return; // No agregar otra fila si ya existe
        }

        // Crear la fila con los totales
        const filaTotal = {
            month: "TOTAL GENERAL", // Columna de "Mes"
            total: totalGeneral.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }), // Columna de "Total Ventas"
        };

        // Agregar la fila al final de la tabla
        table.row.add(filaTotal).draw(false);
    }

    // Ejecutar la función al inicializar o redibujar la tabla
    $('#s_institution_reports-table').on('init.dt draw.dt', function () {
        agregarFilaTotal();
    });
});
