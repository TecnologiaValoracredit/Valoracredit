$(document).ready(function(){
    const user_id = $("#user_id").val()
    const promotor_id = $("#promotor_id").val()
    const coordinator_id = $("#coordinator_id").val()
    window.addInstitution = () => {
        const data = {
            "institution_id": $("#institution_id").val(),
            "percentage": $("#percentage").val()
        }
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/commissions/addInstitution/${promotor_id}`,
            type: "POST",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                //Cerrar el modal y actualizar el datatable
                let dt = window.LaravelDataTables['institution_commission_promotors-table'];
                dt.draw(false)
                $('#institution_id').prop('selectedIndex', 0);
                $('#percentage').val("");

                snackBar(response.message, response.status ? "success" : "danger")
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        })
    }

    window.addInstitutionToCoordinator = () => {
        const data = {
            "institution_id": $("#institution_id").val(),
            "percentage": $("#percentage").val()
        }
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/commissions/addInstitutionToCoordinator/${coordinator_id}`,
            type: "POST",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                //Cerrar el modal y actualizar el datatable
                let dt = window.LaravelDataTables['institution_commission_coordinators-table'];
                dt.draw(false)
                $('#institution_id').prop('selectedIndex', 0);
                $('#percentage').val("");

                snackBar(response.message, response.status ? "success" : "danger")
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        })
    }


     window.addName = () => {
        const data = {
            "s_user_name": $("#s_user_name").val(),
        }
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/commissions/addName/${user_id}`,
            type: "POST",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                //Cerrar el modal y actualizar el datatable
                let dt = window.LaravelDataTables['s_user_names-table'];
                dt.draw(false)
                $('#s_user_name').val("");

                snackBar(response.message, response.status ? "success" : "danger")
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        })
    }

    window.deleteInstitution = (id) => {
        const confirm = alertYesNo(
            'Eliminar institución',
            '¿Estás seguro de eliminar la institución?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/commissions/deleteInstitution/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        var table = window.LaravelDataTables[`institution_commission_promotors-table`];
                        table.draw(false);
                        snackBar("Institución eliminada correctamente", "success")

                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    } 
                });
            }
        })
    }


    window.deleteInstitutionFromCoordinator = (id) => {
        const confirm = alertYesNo(
            'Eliminar institución',
            '¿Estás seguro de eliminar la institución?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/commissions/deleteInstitutionFromCoordinator/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        var table = window.LaravelDataTables[`institution_commission_coordinators-table`];
                        table.draw(false);
                        snackBar("Institución eliminada correctamente", "success")

                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }

    window.deleteName = (id) => {
        const confirm = alertYesNo(
            'Eliminar nombre',
            '¿Estás seguro de eliminar el nombre?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/commissions/deleteName/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        var table = window.LaravelDataTables[`s_user_names-table`];
                        table.draw(false);
                        snackBar("Nombre eliminada correctamente", "success")

                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }

  
    



})