$(document).ready(function(){
    const user_id = $("#user_id").val()

    window.addBankDetails = () => {
        const data = {
            "bank_id": $("#bank_id").val(),
            "account_number": $("#account_number").val()
        }

        console.log(user_id, data);
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/users/addBankDetail/${user_id}`,
            type: "POST",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                //Cerrar el modal y actualizar el datatable
                let dt = window.LaravelDataTables['bank_details-table'];
                dt.draw(false)
                $('#bank_id').prop('selectedIndex', 0);
                $('#account').val("");

                snackBar(response.message, response.status ? "success" : "danger")
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        })
    }

    window.deleteBankDetail = (id) => {
        const confirm = alertYesNo(
            'Eliminar la cuenta',
            '¿Estás seguro de eliminar la cuenta?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/users/deleteBankDetail/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        var table = window.LaravelDataTables[`bank_details-table`];
                        table.draw(false);
                        snackBar("Detalle bancario eliminado correctamente", "success")

                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }

});