const formatterMX = new Intl.NumberFormat('es-MX', {
    style: "currency",
    currency: "MXN",
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});


$('input[type="checkbox"]').on('change', function(){
    const card = $(this).closest('.requisition-card');

    card.find('div.collapse').collapse('toggle');
});

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
    $('.requisition-card input[type="checkbox"]').each(function(index, elem) {
        const card = $(this).closest('.requisition-card');

        const decisionAndNotes = {
            "REQ-FOLIO" : card.data('folio'),
            "amount" : formatterMX.format(card.data('amount')),
            "decision" : $(this).prop('checked') ? "Aprobada" : "Devuelta",
            "notes" : card.data('notes'),
        };
        decisionsAndNotes.push(decisionAndNotes);
    });

    console.log($('.requisition-card select'));

    let txt = ``;

    $.each(decisionsAndNotes, function(index, elem) {
        let color;

        switch (elem['decision']) {
            case 'Aprobada':
                color = 'success';
                break;
            case 'Devuelta':
                color = 'warning';
                break;
            default:
                color = 'black';
        }

        txt += `
        FOLIO: ${elem['REQ-FOLIO']}<br>
        MONTO: ${elem['amount']}<br>
        DECISION: <span class="text-${color}">${elem['decision']}</span><br>
        NOTAS: <span class="text-dark small">${elem['notes']}</span><br><br>
        `;
    });

    return txt;
}

