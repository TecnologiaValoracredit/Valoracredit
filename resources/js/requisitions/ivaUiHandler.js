const percentageInputContainer = $('#percentage_container');
const hasIvaCheckbox = $('#has_iva');

hasIvaCheckbox.on('change', togglePercentage);

function togglePercentage(){
    if (hasIvaCheckbox.prop('checked')){
        percentageInputContainer.addClass('d-none');
        $('#iva_percentage').prop('required', false);
        $('#iva_percentage').val('1');
    }
    else{
        percentageInputContainer.removeClass('d-none');
        $('#iva_percentage').prop('required', true);
        $('#iva_percentage').val('16');
    }
}