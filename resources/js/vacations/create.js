$('.dates-container b.text-danger').remove();
const datesContainer = $('.dates-container');

$('#total_days').on('input', function(e) {
    const value = Number(e.target.value);
    datesContainer.empty();

    if (value > 10) return;

    for (let i = 0; i < value; i++) {
        const input = $('<input>', {
            type: "date",
            class: "form-control",
            name: `vac-date-${i}`,
            required: true,
        });

        const container = $('<div>');

        container.append(input);
        datesContainer.append(container);
    }
});

const form = $('#form');
let sendOnCreate = false;
window.sendOnCreation = function(e) {
    if (!form[0].checkValidity()) return;
    if (sendOnCreate) return;

    sendOnCreate = true;
}

$('#form').on('submit', (e) => {
    if (!form[0].checkValidity()) return;
    $('.btn').prop('disabled', true);

    if (sendOnCreate){
        const input = $('<input>', {
            type: "hidden",
            name: "sendOnCreate",
            value: true,
        });
        form.append(input);
    }
});