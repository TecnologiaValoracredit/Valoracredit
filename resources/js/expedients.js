$(function(){
    window.findExpedient = (id_expedient, credit_id) => {
        const confirm = alertYesNo(
            'Resguardar expediente #' + credit_id,
            '¿Estás seguro de marcar como resguardado el expediente con número de credito '+credit_id+'?',
            'question',
            'Resguardar', 'Cancelar',
            '#00ab55', '#e7515a'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/${$("#route").val()}/${id_expedient}`,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        var table = window.LaravelDataTables[`${$("#route").val()}-table`];
                        table.draw(false);
                        snackBar("Expediente resguardado correctamente", "success")
    
                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    }
                });
            }
        })
    }
});