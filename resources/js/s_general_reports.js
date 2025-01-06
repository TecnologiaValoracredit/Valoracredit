$(function(){
    // Suponiendo que la tabla se llama 's_sales-table' y tiene datos numéricos

    function calcularTotales() {
        const table = window.LaravelDataTables["s_general_reports-table"];
        const data = table.rows({ search: 'applied' }).data();
        
        // Verificar si ya existe la fila de totales
        const lastRow = table.row(':last').data();
        if (lastRow && lastRow.institution_name === "TOTAL GENERAL") {
            return; // No agregar otra fila de totales
        }
        var totals = {
            institution_name: "TOTAL GENERAL",
            january: 0,
            february: 0,
            march: 0,
            april: 0,
            may: 0,
            june: 0,
            july: 0,
            august: 0,
            september: 0,
            october: 0,
            november: 0,
            december: 0,
            total_by_institution: 0,
            percentage_of_total: "100%",
        };
    
        data.each(function (row) {
            totals.january += parseFloat(row.january.replace(/,/g, "")) || 0;
            totals.february += parseFloat(row.february.replace(/,/g, "")) || 0;
            totals.march += parseFloat(row.march.replace(/,/g, "")) || 0;
            totals.april += parseFloat(row.april.replace(/,/g, "")) || 0;
            totals.may += parseFloat(row.may.replace(/,/g, "")) || 0;
            totals.june += parseFloat(row.june.replace(/,/g, "")) || 0;
            totals.july += parseFloat(row.july.replace(/,/g, "")) || 0;
            totals.august += parseFloat(row.august.replace(/,/g, "")) || 0;
            totals.september += parseFloat(row.september.replace(/,/g, "")) || 0;
            totals.october += parseFloat(row.october.replace(/,/g, "")) || 0;
            totals.november += parseFloat(row.november.replace(/,/g, "")) || 0;
            totals.december += parseFloat(row.december.replace(/,/g, "")) || 0;
            totals.total_by_institution += parseFloat(row.total_by_institution.replace(/,/g, "")) || 0;
        });
    
        for (var key in totals) {
            if (typeof totals[key] === "number") { 
                totals[key] = formatNumber(totals[key]);
            }
        }
    
        table.row.add(totals).draw(false);
    }

    $('#s_general_reports-table').on('init.dt draw.dt', function () {
        calcularTotales()
    });
    

   


})

