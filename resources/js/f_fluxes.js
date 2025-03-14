getClasifications()
let ingresosClas, egresosClas
const f_movement_type_id = $("#f_movement_type_id").val()


$.ajax({
    url: $('meta[name="app-url"]').attr('content')+`/f_beneficiaries/getDataAutocomplete`,
    type: 'GET',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(response) {
        autocomplete("f_beneficiary", response, "Buscar...")
    },error: function(xhr, textStatus, errorThrown) {
        errorMessage(xhr.status, errorThrown)
    }
});

async function getClasifications() {
    try {
        let ingresosResponse = await $.ajax({
            url: $('meta[name="app-url"]').attr('content') + `/f_clasifications/getDataAutocomplete/1`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        let egresosResponse = await $.ajax({
            url: $('meta[name="app-url"]').attr('content') + `/f_clasifications/getDataAutocomplete/2`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });

        ingresosClas = ingresosResponse;
        egresosClas = egresosResponse;

        if (f_movement_type_id == 1) {
            autocomplete("f_clasification", ingresosClas, "Buscar...")
        }else {
            autocomplete("f_clasification", egresosClas, "Buscar...")
        }

        // Aquí puedes ejecutar otra función o manipular los datos
    } catch (error) {
        console.error("Error en las peticiones:", error);
    }
}

$("#f_movement_type_id").on("change", function(){
    const f_movement_type_id = parseInt($(this).val())
    $("#f_clasification_id").val("");
    $("#f_clasification_name").val("");

    if (f_movement_type_id == 1) {
        autocomplete("f_clasification", ingresosClas, "Buscar...")
    }else {
        autocomplete("f_clasification", egresosClas, "Buscar...")
    }
})