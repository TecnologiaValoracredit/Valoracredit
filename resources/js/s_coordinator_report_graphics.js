$(document).ready(function() {
    // Función para renderizar la gráfica
    function renderizarGrafica() {
        const table = window.LaravelDataTables["s_coordinator_reports-table"];
        const data = table.rows({ search: 'applied' }).data();

        const coordinators = [];
        const totales = [];

        // Obtener los datos de la tabla
        data.each(function (row) {
            if (row.coordinator_name !== "TOTAL GENERAL") {
                // Asegurarnos de que el nombre esté limpio de HTML
                coordinators.push($("<div>").html(row.coordinator_name).text());
                totales.push(parseFloat(row.total_by_coordinator.replace(/,/g, "")) || 0);
            }
        });

        // Obtener el contexto del canvas
        const ctx = document.getElementById('coordinatorReportGraphic').getContext('2d');

        // Verificar si ya existe una instancia de la gráfica y destruirla
        if (window.myChart instanceof Chart) {
            window.myChart.destroy();
        }

        // Crear una nueva instancia de la gráfica
        window.myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: coordinators,  // Nombres de las coordinators
                datasets: [{
                    label: 'Total por coordinador',
                    data: totales,  // Totales por institución
                    backgroundColor: 'rgba(28, 41, 226, 0.87)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            title: function(tooltipItem) {
                                // Mostrar el nombre completo de la institución
                                return tooltipItem[0].label; 
                            },
                            label: function(tooltipItem) {
                                // Mostrar el total en el tooltip
                                return 'Total: ' + tooltipItem.raw.toLocaleString();
                            }
                        },
                        // Estilo del tooltip
                        bodyFont: {
                            size: 12  // Tamaño de la fuente
                        },
                        titleFont: {
                            weight: 'bold',  // Hacer el título más prominente
                            size: 14  // Ajustar el tamaño del título
                        },
                        displayColors: false,  // No mostrar color extra en el tooltip
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',  // Fondo del tooltip
                        titleColor: '#fff',  // Color del título
                        bodyColor: '#fff',  // Color del cuerpo del tooltip
                        padding: 10,  // Relleno para mayor espacio
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return value.toLocaleString(); }  // Formatear valores
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 10  // Ajuste del tamaño de la fuente para las etiquetas
                            },
                            padding: 10,  // Aumentar el espacio entre las etiquetas
                            autoSkip: true,  // Evita que las etiquetas se solapen
                        },
                        grid: {
                            display: false  // Quitar las líneas de la cuadrícula en el eje X
                        }
                    }
                }
            }
        });
    }

    // Ejecutar al iniciar o cuando se dibuje la tabla
    $('#s_coordinator_reports-table').on('draw.dt init.dt', function () {
        renderizarGrafica();
    });
});
    //Descargar grafica como png
    document.getElementById('downloadBtn').addEventListener('click',function()
    {
        const canvas = document.getElementById('coordinatorReportGraphic');
        const image = canvas.toDataURL('image/png');

        const link = document.createElement('a');
        link.href = image;
        link.download = 'coordinatorReportGraphic.png';
        link.click();
    })
