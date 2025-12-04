$(document).ready(function(){

    $("#btnGenerateContract").on("click", function() {
        const user_id = $("#user_id").val()
        const contract_id = $("#contract_id").val()
        let data = {
            "initial_date": $("#initial_date").val()
        }

        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/contracts/exportContract/${contract_id}/${user_id}`,
            type: "POST",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                //Cerrar el modal y actualizar el datatable
                $("#contracts-table").html(response.table)
                

                snackBar(response.message, response.status ? "success" : "danger")
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        })
    })


    window.deleteContract = (contract_id) => {
        const confirm = alertYesNo(
            'Eliminar contrato permanentemente',
            '¿Estás seguro de eliminar el contrato?'
        );

        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/users_contracts/deleteContract/${contract_id}`,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        //Cerrar el modal y actualizar el datatable
                        $("#contracts-table").html(response.table)
                        
        
                        snackBar(response.message, response.status ? "success" : "danger")
                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                })
            }
        })

    }

      window.addUserContractSigned = (input, user_contract_id) => {
        const file = input.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('contract_signed', file);
    
            $.ajax({
                url: $('meta[name="app-url"]').attr('content') + `/users_contracts/addUserContractSigned/${user_contract_id}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    if (response.status) {
                        $("#contracts-table").html(response.table)
                        snackBar(response.message, "success");
                    } else {
                        snackBar(response.message, "danger");
                    }
                },
                error: function(xhr, status, error) {
                    snackBar("Error al subir el archivo", "danger");
                    console.error("Error:", error);
                }
            });
        }
    }

});