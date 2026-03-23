console.log($('input[type="checkbox"]'));

$('input[type="checkbox"]').on('change', function(){
    const card = $(this).closest('.requisition-card');

    card.find('div.collapse').collapse('toggle');
});