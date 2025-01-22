$(function(){
    // Suponiendo que la tabla se llama 's_sales-table' y tiene datos numéricos

    function calcularTotales() {
        const table = window.LaravelDataTables["s_coordinator_reports-table"];
        const data = table.rows({ search: 'applied' }).data();
        
        // Verificar si ya existe la fila de totales
        const lastRow = table.row(':last').data();
        if (lastRow && lastRow.coordinator_name === "TOTAL GENERAL") {
            return; // No agregar otra fila de totales
        }
        var totals = {
            coordinator_name: "TOTAL GENERAL",
            total_by_coordinator: 0,
        };
    
        data.each(function (row) {
            totals.total_by_coordinator += parseFloat(row.total_by_coordinator.replace(/,/g, "")) || 0;
        });
    
        for (var key in totals) {
            if (typeof totals[key] === "number") { 
                totals[key] = formatNumber(totals[key]);
            }
        }
    
        table.row.add(totals).draw(false);
    }

    $('#s_coordinator_reports-table').on('init.dt draw.dt', function () {
        calcularTotales()
    });
    

   


})

