const formatterMX = new Intl.NumberFormat('es-MX', {
    style: "currency",
    currency: "MXN",
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});

// Alterna la decision de cada requisicion
$('.toggle-btn').on('click', function(){
    const card = $(this).closest('.requisition-card');

    let select = card.find('select');
    let options = select.find('option:not(:disabled)');
    let index = options.index(options.filter(':selected'));

    let nextIndex = (index + 1) % options.length;

    const val = options.eq(nextIndex).val();
    select.val(val).change();

    if (val == 'Devuelta' || val == 'Rechazada'){
        card.find('div.collapse').collapse('show');
    }
    else{
        card.find('div.collapse').collapse('hide');
    }
});

$('select').on('change', function(){
    const card = $(this).closest('.requisition-card');

    if ($(this).val() == 'Devuelta' || $(this).val() == 'Rechazada'){
        card.find('div.collapse').collapse('show');
    }
    else{
        card.find('div.collapse').collapse('hide');
    }
})

//Pide confirmacion sobre todas las decisiones tomadas respecto a las requisiciones
$('#form').on('submit', function(e){
    e.preventDefault();

    const confirm = alertYesNo('Esta seguro de las decisiones tomadas?', getDecisions());
    confirm.then((result) => {
        if (result){
            this.submit();
        }
        else{
            $('.btn').prop('disabled', false);
        }
    })
})

function getDecisions(){
    const decisionsAndNotes = [];
    $('.requisition-card select').each(function(index, elem) {
        const card = $(this).closest('.requisition-card');

        const decisionAndNotes = {
            "REQ-FOLIO" : card.data('folio'),
            "amount" : formatterMX.format(card.data('amount')),
            "decision" : $(this).val(),
        };
        decisionsAndNotes.push(decisionAndNotes);
    });

    let txt = ``;

    $.each(decisionsAndNotes, function(index, elem) {
        txt += `
        FOLIO: ${elem['REQ-FOLIO']}<br>
        MONTO: ${elem['amount']}<br>
        DECISION: ${elem['decision']}<br><br>
        `;
    });

    return txt;
}
