$(function(){
    // Suponiendo que la tabla se llama 's_sales-table' y tiene datos numéricos

    window.filterDT = () => {
        const year = $("#year").val()
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/s_promotor_reports/getTable/${year}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $("#table-promotors").html(response)
                
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    }

   


})

