if ($('#form')){
    let clickedBtn = null;

    $('button[type="submit"]').on('click', function() {
        clickedBtn = this;
    });

    $('form').on('submit', function(e) {
        if (!this.checkValidity()) return;
        if (clickedBtn) {
            $(clickedBtn).prop('disabled', true);
        }
    });
}