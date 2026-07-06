function initMinuteMonthlyReport() {
    const node = document.getElementById('minute-monthly-config');
    if (!node) {
        return;
    }

    let config = null;
    try {
        config = JSON.parse(node.dataset.config || '{}');
    } catch (e) {
        config = null;
    }

    if (!config || !window.Chart) {
        return;
    }

    const labels = config.labels || [];

    const completedCanvas = document.getElementById('chart-monthly-completed');
    if (completedCanvas && labels.length) {
        new window.Chart(completedCanvas, {
            type: 'bar',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Tareas completadas',
                        data: config.completed || [],
                        backgroundColor: '#0ba360',
                        borderRadius: 8,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
            },
        });
    }

    const complianceCanvas = document.getElementById('chart-monthly-compliance');
    if (complianceCanvas && labels.length) {
        new window.Chart(complianceCanvas, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: '% Cumplimiento',
                        data: config.compliance || [],
                        borderColor: '#2c4ad6',
                        backgroundColor: 'rgba(82,121,245,.2)',
                        fill: true,
                        tension: 0.3,
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        min: 0,
                        max: 100,
                    },
                },
            },
        });
    }
}

initMinuteMonthlyReport();
