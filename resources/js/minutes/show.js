function initMinuteShow() {
    const configNode = document.getElementById('minute-config');
    const configJson = configNode?.dataset?.config;
    let M = null;

    if (configJson) {
        try {
            M = JSON.parse(configJson);
        } catch (e) {
            M = null;
        }
    }

    if (!M) {
        return;
    }

    function ajax(url, method, body) {
        return fetch(url, {
            method,
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': M.csrf,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: body ? JSON.stringify(body) : null,
        }).then((r) => r.json());
    }

    function setRowFlash(row, ok) {
        row.style.transition = 'background-color .6s';
        row.style.backgroundColor = ok ? '#d1e7dd' : '#f8d7da';
        setTimeout(() => {
            row.style.backgroundColor = '';
        }, 700);
    }

    const debouncers = new WeakMap();
    document.querySelectorAll('#tasks-table .task-row').forEach((row) => {
        row.addEventListener('change', () => saveRow(row));
        row.addEventListener('input', () => {
            const existing = debouncers.get(row);
            if (existing) {
                clearTimeout(existing);
            }
            debouncers.set(row, setTimeout(() => saveRow(row), 600));
        });

        const deleteBtn = row.querySelector('.task-delete');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                if (!confirm('¿Eliminar esta tarea?')) {
                    return;
                }
                const id = row.dataset.taskId;
                ajax(`${M.updateTaskUrl}/${id}`, 'DELETE').then((res) => {
                    if (res.status) {
                        row.remove();
                    } else {
                        alert(res.message || 'Error al eliminar');
                    }
                });
            });
        }
    });

    function saveRow(row) {
        const id = row.dataset.taskId;
        const payload = {};
        row.querySelectorAll('.task-field').forEach((el) => {
            payload[el.dataset.field] = el.value;
        });
        ajax(`${M.updateTaskUrl}/${id}`, 'PUT', payload).then((res) => setRowFlash(row, !!res.status));
    }

    const addBtn = document.getElementById('btn-add-task');
    if (addBtn) {
        addBtn.addEventListener('click', () => {
            const title = (document.getElementById('new-title')?.value || '').trim();
            if (!title) {
                alert('El titulo es requerido');
                return;
            }
            const payload = {
                title,
                assigned_to: document.getElementById('new-assigned')?.value || null,
                status: document.getElementById('new-status')?.value,
                priority: document.getElementById('new-priority')?.value,
                due_date: document.getElementById('new-due')?.value || null,
                progress: parseInt(document.getElementById('new-progress')?.value || 0, 10),
                comments: document.getElementById('new-comments')?.value || null,
            };
            ajax(M.storeTaskUrl, 'POST', payload).then((res) => {
                if (res.status) {
                    location.reload();
                } else {
                    alert(res.message || 'Error al guardar');
                }
            });
        });
    }

    const txt = document.getElementById('task-filter');
    const st = document.getElementById('task-status-filter');
    const applyFilters = () => {
        const q = (txt?.value || '').toLowerCase();
        const s = st?.value || '';
        document.querySelectorAll('#tasks-table .task-row').forEach((row) => {
            const matchesText = !q || row.innerText.toLowerCase().includes(q);
            const matchesStatus = !s || row.dataset.status === s;
            row.style.display = matchesText && matchesStatus ? '' : 'none';
        });
    };
    if (txt) {
        txt.addEventListener('input', applyFilters);
    }
    if (st) {
        st.addEventListener('change', applyFilters);
    }

    if (window.Chart) {
        const ctx1 = document.getElementById('chart-assignees');
        if (ctx1 && Array.isArray(M.metrics?.byAssignee) && M.metrics.byAssignee.length) {
            new window.Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: M.metrics.byAssignee.map((x) => x.name),
                    datasets: [
                        { label: 'Total', data: M.metrics.byAssignee.map((x) => x.total), backgroundColor: '#5279f5' },
                        { label: 'Completadas', data: M.metrics.byAssignee.map((x) => x.completed), backgroundColor: '#3cba92' },
                    ],
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } },
            });
        }

        const ctx2 = document.getElementById('chart-weekly');
        if (ctx2 && Array.isArray(M.weekly) && M.weekly.length) {
            new window.Chart(ctx2, {
                type: 'line',
                data: {
                    labels: M.weekly.map((x) => x.label),
                    datasets: [
                        {
                            label: '% cumplimiento',
                            data: M.weekly.map((x) => x.compliance),
                            borderColor: '#0ba360',
                            backgroundColor: 'rgba(11,163,96,.15)',
                            fill: true,
                            tension: 0.3,
                        },
                    ],
                },
                options: { responsive: true, scales: { y: { min: 0, max: 100 } } },
            });
        }
    }
}

window.initMinuteShow = initMinuteShow;
initMinuteShow();
