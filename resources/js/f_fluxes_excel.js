let ingresosClas, egresosClas
getClasifications()

$("#upload-form").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    
    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/f_fluxes/importExcel`,
        type: "POST",
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            
            if (typeof response === "object" && response !== null && "status" in response) {
                // Caso: JSON
                if (!response.status) {
                    alert(response.data[0] + ": " + getNotFoundedCredits(response.data));
                }
            } else {
                // Caso: HTML
                $("#table-excel").html(response);
                loadAutocompleteBeneficiaries(getInputNameBeneficiaries("f_beneficiary"))
                loadAutocompleteClasifications(getInputNamesClasifications("f_clasification"))
            }
            
        },
        error: function(response) {
            alert("error al subir el archivo")
        }
    });
});

function getNotFoundedCredits(data){
    let credits = "";
    data.slice(1).forEach(item => {
        credits += item + ", ";
    });
    return credits;
}


window.deleteRowExcel = (param) => {
    $(param).closest("tr").remove();
}

//obtener todos los input f_beneficiary para hacerlos autocomplete
function getInputNameBeneficiaries(className){
    let inputs = [];

    $("."+className).each(function() {
        let name = $(this).find("[type='text']").attr("id").replace("_name", ""); // Obtener el valor del input de texto
        inputs.push(name);
    });
    return inputs; // Ver el resultado en la consola
}

//obtener todos los input f_beneficiary para hacerlos autocomplete
function getInputNamesClasifications(className){
    let inputs = [];

    $("."+className).each(function() {
        let name = $(this).find("[type='text']").attr("id").replace("_name", ""); // Obtener el valor del input de texto
        
        let tr = $(this).closest('tr');
        let movementTypeTd = tr.find('.f_movement_type');
        let f_movement_type_id = movementTypeTd.find('select').val();

        inputs.push({ name: name, f_movement_type_id: f_movement_type_id });
    });
    
    return inputs; // Ver el resultado en la consola
}

function loadAutocompleteClasifications(f_clasifications)
{
    f_clasifications.forEach(function(f_clasification) {
        if (f_clasification.f_movement_type_id == 1) {
            autocomplete(f_clasification.name, ingresosClas, "Buscar...")
        }else {
            autocomplete(f_clasification.name, egresosClas, "Buscar...")
        }
    })
}

function loadAutocompleteBeneficiaries(f_beneficiaries)
{
    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/f_beneficiaries/getDataAutocomplete`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            f_beneficiaries.forEach(function(beneficiary) {
                autocomplete(beneficiary, response, "Buscar...", onSelectBeneficiary)
            });
        },error: function(xhr, textStatus, errorThrown) {
            errorMessage(xhr.status, errorThrown)
        }
    });
}

window.reloadBeneficiary = (beneficiary) => {
    loadAutocompleteBeneficiaries([beneficiary])
}

$(document).on("change", ".f_movement_type_select", function(){
    const f_movement_type_id = parseInt($(this).val())
    const tr = $(this).closest('tr');
    const td = tr.find('.f_clasification');
    const inputText = $(td).find("[type='text']"); 
    const input = $(td).find("[type='hidden']"); 
    const name = inputText.attr("id").replace("_name", "")
    inputText.val("");
    input.val("")
    
    if (f_movement_type_id == 1) {
        autocomplete(name, ingresosClas, "Buscar...")
    }else {
        autocomplete(name, egresosClas, "Buscar...")
    }
})


function onSelectBeneficiary(){
    $(".beneficiary_name").each(function() {
        const td = $(this).closest(".f_beneficiary")
        const inputHidden = td.find(".beneficiary_id_hidden")
        const inputText = $(this)
        if (inputHidden.val() == "") {
            inputText.addClass("error-null")
        }else{
            inputText.removeClass("error-null")
        }
    })
}

function onInputBeneficiary(beneficiary){
    $(`#${beneficiary}_name`).addClass("error-null");
    $(`#${beneficiary}_id`).val("");
}
   


function getClasifications()
{
    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/f_clasifications/getDataAutocomplete/1`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            ingresosClas = response
        },error: function(xhr, textStatus, errorThrown) {
            errorMessage(xhr.status, errorThrown)
        }
    });
    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/f_clasifications/getDataAutocomplete/2`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            egresosClas = response
        },error: function(xhr, textStatus, errorThrown) {
            errorMessage(xhr.status, errorThrown)
        }
    });
}


$('#openBeneficiaryModal').click(function() {        
    $.ajax({
        url: $('meta[name="app-url"]').attr('content')+`/f_beneficiaries/getAddModal`,
        method: 'GET',
        success: function(response) {
            $('#addBeneficiaryModal .modal-body').html(response);
            $('#addBeneficiaryModal').modal('show');
        }
    });
});

$("#beneficiaryModal").on("submit", function(e) {
    e.preventDefault();
    let url = $('meta[name="app-url"]').attr('content')+`/f_beneficiaries`
    let method = "POST"
    if (this.checkValidity()) {
        const form = $("#beneficiaryModal").serialize()
        $.ajax({
            url: url,
            type: method,
            data: form,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.status) {
                    snackBar(response.message, "success")
                    $('#addBeneficiaryModal').modal('hide');
                }else {
                    snackBar(response.message, "warning")
                }
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        })
    };
})