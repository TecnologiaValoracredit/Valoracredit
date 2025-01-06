
$(function () {
    // Inicializar DataTable si no está inicializado
    if (!$.fn.DataTable.isDataTable('#s_general_reports-table')) {
        $('#s_general_reports-table').DataTable();
    }

    // Función para obtener los datos y renderizar la gráfica
    function renderizarGrafica() {
        const table = window.LaravelDataTables["s_general_reports-table"];
        const data = table.rows({ search: 'applied' }).data();

        const instituciones = [];
        const totales = [];

        // Obtener los datos de la tabla
        data.each(function (row) {
            if (row.institution_name !== "TOTAL GENERAL") {
                instituciones.push(row.institution_name);
                totales.push(parseFloat(row.total_by_institution.replace(/,/g, "")) || 0);
            }
        });

        // Configuración de la gráfica
        Highcharts.chart('container', {
            chart: {
                type: 'column',
                height: 400, // Altura de la gráfica
            },
            title: {
                text: 'Totales por Institución',
            },
            xAxis: {
                categories: instituciones,
                crosshair: true,
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total ($)',
                },
            },
            tooltip: {
                valuePrefix: '$',
                valueDecimals: 2,
            },
            series: [
                {
                    name: 'Total por Institución',
                    data: totales,
                },
            ],
        });
    }

    // Renderizar gráfica al inicializar o actualizar la tabla
    $('#s_general_reports-table').on('draw.dt init.dt', function () {
        renderizarGrafica();
    });
});
