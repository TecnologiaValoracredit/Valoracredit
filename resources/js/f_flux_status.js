window.changeStatus = (id) => {
    const confirm = alertYesNo(
        'Cambiar estado',
        '¿Estás seguro de cambiar el estado?'
    );
    confirm.then((result) => {
        if (result) {
            $.ajax({
                url: $('meta[name="app-url"]').attr('content')+`/f_fluxes/changeStats/${id}`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    
                    var table = window.LaravelDataTables[`${$("#route").val()}-table`];
                    table.draw(false);
                    snackBar("Flujo desactivado correctamente", "success")

                },error: function(xhr, textStatus, errorThrown) {
                    errorMessage(xhr.status, errorThrown)
                }
            });
        }
    })
}