const form = $('#fixed_expense_form');
const fixedExpenseInput = $('#fixed_expense_id');

$('#is_fixed').on('change', () => {
    $('#fixedExpenseFields').collapse('toggle');
})

form.on('submit', getFixedExpenseFields);

function getFixedExpenseFields(e){
    e.preventDefault();
    const fixedExpenseId = fixedExpenseInput.val();

    if (!fixedExpenseId){
        simpleAlert("Valor inválido", "Ingrese un gasto fijo válido", 'warning');
        return;
    }

    $('#fixed_expense_btn').prop('disabled', true);

    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/fixed_expenses/${fixedExpenseId}/getFields`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            repopulateRequisitionFields(response);
            repopulateRequisitionRowsTable(response);

            $('#fixed-expense-modal').modal('hide');

            //Remueve los nodos de gasto fijo
            $('#is_fixed').parent().remove();
            $('#fixedExpenseFields').remove();
            $('#fixed_expense_modal_btn').remove();

            snackBar("Campos llenados correctamente", "success");

        },
        error: function (xhr, textStatus, errorThrown) {
            errorMessage(xhr.status, errorThrown);
        }
    });
}

function repopulateRequisitionFields(response){
    $('#expense_type_id').val(response['requisition']['expense_type_id']);
    $('#payment_type_id').val(response['requisition']['payment_type_id']);
    $('#supplier_id').val(response['requisition']['supplier_id']);
    $('#notes').val(response['requisition']['notes']);
    $('#is_urgent').val(response['requisition']['is_urgent']);
}

function repopulateRequisitionRowsTable(response){
    const tableBody = $('#table_body');

    for (let i = 0; i < response['requisition_rows'].length; i++) {
        const requisitionRow = response['requisition_rows'][i];
        let row = $('<tr>');

        //AÑADE FILA CON LA INFO DE CADA PRODUCTO
        row.append($('<td>').text(requisitionRow['product']));
        row.append($('<td>').text(requisitionRow['product_quantity']));
        row.append($('<td>').text(`${requisitionRow['product_cost']}`));
        row.append($('<td>').text(requisitionRow['has_iva'] == 1 ? "SI" : "NO"));
        row.append($('<td>').text(requisitionRow['iva_percentage'] == 1 ? "NO APLICA" : requisitionRow['iva_percentage']));
        row.append($('<td>').text(`${requisitionRow['total_cost']}`));
        row.append($('<td>').html(getActions()));

        row.append($('<input>', {type:"hidden", name:"currency_type_id", value: requisitionRow['currency_type_id']}));
        row.append($('<input>', {type:"hidden", name:"has_iva", value: requisitionRow['has_iva'] ? "on" : "off"}));
        row.append($('<input>', {type:"hidden", name:"iva_percentage", value: requisitionRow['iva_percentage'] ?? ""}));
        row.append($('<input>', {type:"hidden", name:"link", value: requisitionRow['link'] ?? ""}));
        row.append($('<input>', {type:"hidden", name:"product", value: requisitionRow['product']}));
        row.append($('<input>', {type:"hidden", name:"product_cost", value: requisitionRow['product_cost']}));
        row.append($('<input>', {type:"hidden", name:"product_description", value: requisitionRow['product_description']}));
        row.append($('<input>', {type:"hidden", name:"product_quantity", value: requisitionRow['product_quantity']}));
        row.append($('<input>', {type:"hidden", name:"reason", value: requisitionRow['reason']}));
        row.append($('<input>', {type:"hidden", name:"total_cost", value: requisitionRow['total_cost']}));
        row.append($('<input>', {type:"hidden", name:"has_no_evidence", value: true}));
        
        tableBody.append(row);
    }

    addExistingProductsOnEdit();
}

function getActions(){
    let actions =
        `
        <a onclick="editProduct(this)" title="Editar" class="btn btn-outline-secondary btn-icon p-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
            </svg>
        </a>
        <a onclick="deleteProduct(this)" title="Eliminar" class="btn btn-outline-danger btn-outline-danger btn-icon p-auto">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            </svg>
        </a>
    `;

    return actions;
}