const evidenceContainer = $('#evidence-container');
const modal = $('#reg-modal');
let currentDomRow;


if ($('#form')){
    $('form').on('submit', function(e) {
        if (!this.checkValidity()) return;
        $('.btn').prop('disabled', true);
    });
}

modal.on('hidden.bs.modal', clearContainer);

window.requestEvidences = function(row, domElem){
    currentDomRow = $(domElem).closest('tr');
    console.log(currentDomRow);
    
    if (currentDomRow.length === 0){
        currentDomRow = $(domElem).closest('#see-products-container');
    }

    fillModalFields(row);

    const id = row['id'];
    $.ajax({
        url: `/requisition_row_evidences/${id}/evidences`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            appendEvidences(response);
        },
        error: function(xhr, textStatus, errorThrown){
            errorMessage(xhr.status, errorThrown)
        }
    });
}

function fillModalFields(row){
    $('#product').text(row['product']);
    $('#product_description').text(row['product_description']);
    $('#product_quantity').text(row['product_quantity']);
    $('#has_iva').text(row['has_iva'] == 1 ? 'SI' : 'NO');
    $('#total_cost').text(`$${row['total_cost']}`);
    $('#reason').text(row['reason'] ?? 'No especificada');

    if (row['link']){
        $('#link').append(`
                <a href="${row['link']}" class="link-primary text-center" target="_blank">
                    Visitar sitio
                </a>
        `);
    }
    else{
        $('#link').text(row['link'] ?? 'No especificado');          
    }

    $('#currency_type_id').text(convertIdToValue('currency_type_id') ?? '');
    $('#notes').text(row['notes'] ?? 'No especificadas');
    $('#iva_percentage').text(row['iva_percentage'] == 1 ? 'NO APLICA' : `%${row['iva_percentage']}`);
    
    if (row['starting_date'] && row['ending_date']){
        let startingDate = new Date(row['starting_date']);
        let endingDate = new Date(row['ending_date']);
    
        startingDate = startingDate.toLocaleDateString('es-MX', {day:'2-digit', month:'2-digit', year:'numeric'});
        endingDate = endingDate.toLocaleDateString('es-MX', {day:'2-digit', month:'2-digit', year:'numeric'});
    
        $('#duration').text(`${startingDate} - ${endingDate}`);
    }
    else{
        $('#duration').text('N/A');
    }

}

function convertIdToValue(key){
    return currentDomRow.find(`input[name=${key}]`).attr('value');
}

function appendEvidences(response){

    const paths = Object.values(response);
    
    for (let i = 0; i < paths.length; i++) {
        const path = response[i];
        const src = path['path'];

        const extension = String(src).slice(-3); 

        let evidenceNode = $('<div></div>');
        evidenceNode.addClass('d-flex justify-content-center align-items-center border');

        if (extension == 'pdf'){
            evidenceNode.append(`
                <a href="${src}" class="link-primary text-center" target="_blank">
                    Ver PDF
                </a>
            `);
        }
        else{
            evidenceNode.append(`
                <a href="${src}" target="_blank">
                    <img src="${src}" style="width:110px;">
                </a>
            `);
        }
        evidenceNode.width(150);
        evidenceNode.height(150);

        evidenceContainer.append(evidenceNode);
    }   
}

function clearContainer(){
    evidenceContainer.empty();
}

window.sendRequisition = function(id){
    $('.btn').prop('disabled', true);
    $.ajax({
            url: `/requisitions/${id}/send`,
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(response) {
                if (response['status'] == true){
                    window.location.href = '/requisitions' 
                }
            },
            error: function(xhr, textStatus, errorThrown){
                errorMessage(xhr.status, errorThrown)
                $('#send_requisition_btn').prop('disabled', false);
            }
    });
}
window.deleteRequisition = function(id){
    $('.btn').prop('disabled', true);
    $.ajax({
            url: `/requisitions/${id}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(response) {
                if (response['status'] == true){
                    window.location.href = '/requisitions' 
                }
            },
            error: function(xhr, textStatus, errorThrown){
                errorMessage(xhr.status, errorThrown)
            }
    });
}
window.cancelRequisition = function(id){
    $('.btn').prop('disabled', true);
    $.ajax({
            url: `/requisitions/${id}/cancel`,
            type: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest',
            },
            success: function(response) {
                if (response['status'] == true){
                    window.location.href = '/requisitions' 
                }
            },
            error: function(xhr, textStatus, errorThrown){
                errorMessage(xhr.status, errorThrown)
            }
    })
}