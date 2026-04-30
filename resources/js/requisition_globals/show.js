const mediaQuery = window.matchMedia('(max-width: 768px)');

function handleMediaSizing(e) {
    const a = $('.collapsable').closest('.requisition-card').find('a[target="_blank"]:not(.policy-link)');

    if (e.matches) {
        //Lo hace collapsable al div que contiene la información
        $('.collapsable').addClass('collapse');

        //Cambia colores a no interactuados
        //No cambia el color del fondo si no es bg-primary
        if (a.closest('.requisition-card').find('.bg-gradient').hasClass('bg-primary')){
            a.closest('.requisition-card').find('.bg-gradient').toggleClass('bg-primary bg-light');
            a.toggleClass('link-light link-dark');
        }

        //Collapse en vez de llevar a link de requisicion
        a.on('click', function(e) {
            e.preventDefault();
        });

        a.closest('.requisition-card').find('div.bg-gradient').on('click', function(e) {
            $(this).closest('.requisition-card').find('.collapsable').collapse('toggle');
        })
        a.closest('.requisition-card').find('div.bg-gradient').one('click', function(e) {
            if ($(this).closest('.requisition-card').find('.bg-gradient').hasClass('bg-light')){
                //Cambia color de bg
                $(this).toggleClass('bg-light bg-primary');
                //Cambia color de link
                $(this).find('a[target="_blank"]:not(.policy-link)').toggleClass('link-dark link-light');
            }
        })
    }
    else {
        $('.collapsable').removeClass('collapse');
        a.off();
    }
}

mediaQuery.addEventListener('change', handleMediaSizing);
handleMediaSizing(mediaQuery);

$('#form').on('submit', function(e) {
    if (!this.checkValidity()) {
        simpleAlert("Cuentas no seleccionadas", "Cada requisición debe contar con una cuenta asignada", 'warning');
        return;
    }
})

const tabs = $('button.nav-link:not([id="suppliers-tab"])');
tabs.one('click', function (e) {
    $(this).addClass('bg-gradient bg-light');
    if ($(this).hasClass('bg-warning')){
        $(this).removeClass('bg-warning');
    }
});