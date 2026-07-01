const formatterMX = new Intl.NumberFormat('es-MX', {
    style: "currency",
    currency: "MXN",
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});

const reqsWithBanks = $('.requisition-card select');


// AJAX PARA ACTUALIZAR BANCO AL HACER SELECT DE CADA REQUISICIÓN
if (reqsWithBanks.length > 0){
    reqsWithBanks.on('change', updateBank);

    $('#form').on('submit', function(e) {
        e.preventDefault();
        if (!this.checkValidity()) {
            simpleAlert("Cuentas no seleccionadas", "Cada requisición debe contar con una cuenta asignada", 'warning');
            return;
        }

        const confirm = alertYesNo('Esta seguro de las cuentas seleccionadas?', getAccounts());
        confirm.then((result) => {
            if (result){
                const formAction = $('button[type="submit"]').attr('formaction');
                this.action = formAction;
                this.submit();
            }
            else{
                $('.btn').prop('disabled', false);
            }
        })
    })
}

function updateBank(){
    const reqId = $(this).closest('.requisition-card').data('id');
    const bankId = $(this).val();
    
    const data = {
        'bank_id': bankId,
    };

    $.ajax({
        url: `/requisitions/${reqId}/updateBank`,
        type: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(data),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest',
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
}

function getAccounts(){
    const accounts = [];
    $('.requisition-card select').each(function(index, elem) {
        const card = $(this).closest('.requisition-card');

        const reqAndAccount = {
            "REQ-FOLIO" : card.data('folio'),
            "amount" : formatterMX.format(card.data('amount')),
            "account" : $(this).find('option:selected').text(),
            "notes" : card.data('notes'),
        };
        accounts.push(reqAndAccount);
    });

    let txt = ``;

    $.each(accounts, function(index, elem) {
        txt += `
        FOLIO: ${elem['REQ-FOLIO']}<br>
        MONTO: ${elem['amount']}<br>
        CUENTA: ${elem['account']}<br>
        NOTAS: <span class="text-dark small">${elem['notes']}</span><br><br>
        `;
    });

    return txt;
}
