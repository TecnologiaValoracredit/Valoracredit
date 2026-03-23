const form = $('#form');
const selectAllBtn = $('#select_all_btn');

form.on('submit', checkInputExistence);
selectAllBtn.on('click', toggleAllInputs);

function checkInputExistence(e){
    if (!this.checkValidity()) return;
    $('#submit_btn').prop('disabled', true);
}

let allSelected = true;
function toggleAllInputs(){
    allSelected = !allSelected;

    $('#t_body input[type="checkbox"]').prop('checked', allSelected);
}

// HABILITA TOOLTIP DE LA VISTA SHOW
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})