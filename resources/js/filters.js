window.loadDatatable = function() {
    if(window.LaravelDataTables != undefined) {
        window.LaravelDataTables[$("#route").val()+"-table"].on('preXhr.dt', function ( e, settings, data ) {
            $('.datatable-filter').each(function(index, el) {
                data[$(el).prop('name')] = $(el).val();
            });
        });
    }
}

window.filterDT = () => {
    console.log(window.LaravelDataTables);

    if(window.LaravelDataTables != undefined) {
        loadDatatable();
        window.LaravelDataTables[$("#route").val()+"-table"].draw();
    }
}

window.clearFilters = () => {
    $('.datatable-filter').each(function(index, el) {
        $(el).val("");
    });
}