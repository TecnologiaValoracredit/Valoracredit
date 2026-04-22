if ($('#form')){
    $('form').on('submit', function(e) {
    if (!this.checkValidity()) {
        simpleAlert("Faltan campos obligatorios por llenar", "Por favor, llene los campos obligatorios y seleccione la requisición que conformará el Gasto Recurrente", 'warning');
        return;
    }
        $('.btn').prop('disabled', true);
    });
}