//Deactvate job position upon entering to avoid showing all options
let jobSelect = document.getElementById('position_id');
jobSelect.innerHTML = '<option disabled selected value="">Seleccione una opción...</option>';
jobSelect.disabled = true;

document.getElementById('departament_id').addEventListener('change', function() {
    let departamentId = this.value;

    // Reset job positions
    jobSelect.innerHTML = '<option disabled selected value="">Seleccione una opción...</option>';
    jobSelect.disabled = true;

    if (departamentId) {
        fetch(`/departaments/${departamentId}/job-positions`, {
            credentials: "include"
        })
            .then(response => response.json())
            .then(data => {
                data.forEach(job => {
                    console.log(job);
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