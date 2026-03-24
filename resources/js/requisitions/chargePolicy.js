window.removeRequiredFields = function() {
    $('#evidence').prop('required', false);
    $('#evidence').siblings('b.text-danger').remove();
    $('#poliza_number').prop('required', false);
    $('#poliza_number').siblings('b.text-danger').remove();
}