const mediaQuery = window.matchMedia('(max-width: 768px)');

function handleMediaSizing(e) {
    const a = $('.collapsable').closest('.requisition-card').find('a[target="_blank"]');

    if (e.matches) {
        //Lo hace collapsable al div que contiene la información
        $('.collapsable').addClass('collapse');

        //Cambia colores a no interactuados
        a.closest('.requisition-card').find('.bg-gradient').toggleClass('bg-primary bg-light');
        a.toggleClass('link-light link-dark');

        //Event listener para cambiar de color solo una vez
        a.one('click', function (e) {
            const bg = $(this).closest('.requisition-card').find('.bg-gradient');
            bg.toggleClass('bg-light bg-primary');

            $(this).toggleClass('link-dark link-light');
        })

        //Collapse en vez de llevar a link de requisicion
        a.on('click', function(e) {
            e.preventDefault();
            $(this).closest('.requisition-card').find('.collapsable').collapse('toggle');
        });
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
    console.log('testttttttt')
    $(this).addClass('bg-gradient bg-light');
});