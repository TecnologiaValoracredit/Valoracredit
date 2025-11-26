// //Deactvate job position upon entering to avoid showing all options
let jobSelect = document.getElementById('position_id');

if (!Number(jobSelect.value)){
    jobSelect.innerHTML = '<option disabled selected value="">Seleccione un departamento...</option>';
}

document.getElementById('departament_id').addEventListener('change', function() {
    let departamentId = this.value;

    // Reset job positions
    jobSelect.innerHTML = '<option disabled selected value="">Cargando puestos de trabajo...</option>';
    jobSelect.disabled = true;

    if (departamentId) {
        fetch(`/departaments/${departamentId}/job-positions`, {
            credentials: "include"
        })
            .then(response => response.json())
            .then(data => {
                data.forEach(job => {
                    let option = document.createElement('option');
                    option.value = job.id;
                    option.text = job.name;
                    jobSelect.appendChild(option);
                });
                jobSelect.disabled = false;
            })
            .catch(error => console.error('Error:', error));
    }
});