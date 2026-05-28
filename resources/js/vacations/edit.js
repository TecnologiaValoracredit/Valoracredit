//Al cargar la pagina, busca inputs hidden que son hijos de vacation-dates, para agregarlos al DOM
$(window).on('DOMContentLoaded', function(e) {
    $('#vacation-dates input').each(function (i) {
        const input = $('<input>', {
            type: "date",
            value: $(this).val(),
            class: "form-control",
            name: `vac-date-${i}`,
            required: true,
        });

        const container = $('<div>');
        container.append(input);
        $('.dates-container').append(container);
    })
})