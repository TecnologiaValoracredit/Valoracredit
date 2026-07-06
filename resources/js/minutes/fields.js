function initMinuteFields() {
    const usersNode = document.getElementById('minute-users-data');
    const wrapper = document.getElementById('participants-wrapper');
    const addBtn = document.getElementById('add-participant');

    if (!usersNode || !wrapper || !addBtn) {
        return;
    }

    let users = {};
    try {
        users = JSON.parse(usersNode.textContent || '{}');
    } catch (e) {
        users = {};
    }

    let counter = wrapper.querySelectorAll('.participant-row').length;

    const buildOptions = (selected) => {
        let html = '<option disabled selected value="">Seleccione un usuario...</option>';
        Object.keys(users).forEach((id) => {
            const selectedText = String(id) === String(selected) ? 'selected' : '';
            html += `<option value="${id}" ${selectedText}>${users[id]}</option>`;
        });
        return html;
    };

    const attendanceOptions = (selected) => {
        const opts = { present: 'Presente', absent: 'Ausente', excused: 'Justificado' };
        let html = '<option value="">Seleccione...</option>';
        Object.keys(opts).forEach((k) => {
            const selectedText = k === selected ? 'selected' : '';
            html += `<option value="${k}" ${selectedText}>${opts[k]}</option>`;
        });
        return html;
    };

    addBtn.addEventListener('click', () => {
        const i = counter++;
        const row = document.createElement('div');
        row.className = 'row align-items-end mb-2 participant-row';
        row.innerHTML = `
            <div class="col-md-5">
                <label class="form-label">Usuario</label>
                <select class="form-control" name="participants[${i}][user_id]">${buildOptions('')}</select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Asistencia</label>
                <select class="form-control" name="participants[${i}][attendance_status]">${attendanceOptions('')}</select>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger remove-participant w-100">x</button>
            </div>
        `;
        wrapper.appendChild(row);
    });

    wrapper.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-participant')) {
            e.target.closest('.participant-row')?.remove();
        }
    });
}

initMinuteFields();
