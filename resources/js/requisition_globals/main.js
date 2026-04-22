const form = $('#form');
const selectAllBtn = $('#select_all_btn');


const formatterMX = new Intl.NumberFormat('es-MX', {
    style: "currency",
    currency: "MXN",
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});
const fixedTotal = $('#fixed-total');
$('input[type="checkbox"]').on('change', function (e) {
    let price = $(this).closest('tr').find('.price').text();
    price = Number(String(price).replace(/[^0-9.-]+/g, ''));
    
    let fixedTotalVal = fixedTotal.text();
    fixedTotalVal = Number(String(fixedTotalVal).replace(/[^0-9.-]+/g, ''));

    let updatedTotal;
    if ($(this).prop('checked')){
        updatedTotal = formatterMX.format(fixedTotalVal + price);
    }
    else{
        updatedTotal = formatterMX.format(fixedTotalVal - price);
    }

    fixedTotal.text(updatedTotal);
})

function calculateInitialTotal() {
    let total = 0;

    $('input[type="checkbox"]:checked').each(function () {
        let price = $(this).closest('tr').find('.price').text();
        price = Number(String(price).replace(/[^0-9.-]+/g, ''));
        total += price;
    });

    $('#fixed-total').text(formatterMX.format(total));
}

$(document).ready(function () {
    calculateInitialTotal();
});

form.on('submit', checkInputExistence);
selectAllBtn.on('click', toggleAllInputs);

function checkInputExistence(e){
    if (!this.checkValidity()) return;
    $('.btn').prop('disabled', true);
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