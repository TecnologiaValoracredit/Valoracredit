$(function(){

window.alertYesNo = (title, text, icon = 'question', confirmText = "Aceptar", cancelText = "Cancelar", confirmColor = "#d33", cancelColor = "#3085d6") => {
    return new Promise((resolve) => {
            Swal.fire({
            title: title,
            html: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            confirmButtonText: confirmText,
            cancelButtonColor: cancelColor,
            cancelButtonText: cancelText,
            }).then((result) => {
            if (result.isConfirmed) {
                resolve(true);
            } else {
                resolve(false);
            }
        });
    });
};



window.deleteRow = (id) => {
    const confirm = alertYesNo(
        'Eliminar registro',
        '¿Estás seguro de eliminar el registo?'
    );
    confirm.then((result) => {
        if (result) {
            $.ajax({
                url: $('meta[name="app-url"]').attr('content')+`/${$("#route").val()}/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    var table = window.LaravelDataTables[`${$("#route").val()}-table`];
                    table.draw(false);
                    snackBar("Registro desactivado correctamente", "success")

                },error: function(xhr, textStatus, errorThrown) {
                    errorMessage(xhr.status, errorThrown)
                }
            });
        }
    })
}

window.simpleAlert = (title, text, icon = 'success') => {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#003F77',

    })
}

window.errorMessage = (errorCode, errorThrown) => {
    if (errorCode == "401") {
        simpleAlert("Usuario no autorizado", "No cuentas con permisos suficientes para realizar esta acción", 'warning')
    }else{
        simpleAlert(errorCode, errorThrown, 'error')
    }
}

const tpyes = {
    "success": "#00ab55",
    "warning": "#e2a03f",
    "info": "#4361ee",
    "danger": "#e7515a"
}

window.snackBar = (text, type, color) => {
    Snackbar.show({ 
        text: text,
        actionTextColor: '#fff',
        backgroundColor: color ?? (tpyes[type] ?? "#4361ee"),
        duration: 1500
    });
}

window.formatNumber = (num) => {
    return num.toLocaleString("es-MX", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

})