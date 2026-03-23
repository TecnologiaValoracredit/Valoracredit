const supplierForm = $('#supplier_form');
const closeForm = $('#close_supplier_form');

supplierForm.on('submit', addSupplier);

function addSupplier(e){
    e.preventDefault();
    const formData = new FormData(this); 

    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/suppliers`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            let option = $('<option/>', {
                value: response['data']['id'],
                text: response['data']['name'],
            });

            $('#supplier_id').append(option);
            $('#supplier-add-modal').modal('hide');

            snackBar("Proveedor agregado correctamente", "success");
        },
        error: function (xhr, textStatus, errorThrown) {
            errorMessage(xhr.status, errorThrown);
        }
    });    
}