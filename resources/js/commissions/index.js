$(document).ready(function(){
    $("#exportCommissionsForm").on("submit", function(e) {
        e.preventDefault();
        const initial_date = $('#initial_date').val();
        const final_date = $('#final_date').val();

        const formData = new FormData(this);
        formData.append('initial_date', initial_date);
        formData.append('final_date', final_date);

        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/commissions/export_report`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            xhrFields: {
                responseType: 'blob' // <-- importante para manejar archivos binarios
            },
            success: function(response, status, xhr) {
                const disposition = xhr.getResponseHeader('Content-Disposition');
                let filename = "comisiones.xlsx";
                if (disposition && disposition.indexOf('filename=') !== -1) {
                    filename = disposition
                        .split('filename=')[1]
                        .replace(/['"]/g, '')
                        .trim();
                }
                const blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                link.click();
                

            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    });
});