let formSubmitted = false;

$(document).ready(function(){
    const user_id = $("#user_id").val()
    const promotor_id = $("#promotor_id").val()
    const coordinator_id = $("#coordinator_id").val()
    const manager_id = $("#manager_id").val()
    const requisition_id = $("#requisition_id").val()

    const requisitionForm = document.getElementById('requisition_form');
    requisitionForm.addEventListener('submit', (e) => {
        console.log('testing');
        formSubmitted = true;
    });

    let table = window.LaravelDataTables['requisition_rows-table'];

   function updateAmount() {
    let columnData = table.column(4, { search: 'applied' }).data();

    let sum = columnData.reduce(function (a, b) {
        // Limpia símbolos y separadores de miles antes de parsear
        let numA = parseFloat(String(a).replace(/[^0-9.-]+/g, '')) || 0;
        let numB = parseFloat(String(b).replace(/[^0-9.-]+/g, '')) || 0;
        return numA + numB;
    }, 0);

    // Muestra con formato de dinero
    $('#amount').val(sum.toFixed(2));
}

    // recalcular cada vez que se redibuja la tabla
    table.on('draw', function () {
        updateAmount();
    });

    // llamar al inicio
    updateAmount();

    window.handleFormSubmit = (e) => {
        e.preventDefault(); // evita el envío tradicional del form

        // Detectar si hay un ID oculto (por ejemplo, para saber si es edición)
        const isEdit = !!$('#requisition_row_id').val();

        if (isEdit) {
            console.log("aaaaaassss")

            updateProduct($('#requisition_row_id').val());
        } else {
            console.log("aaaaaa")

            addProduct();
        }
    };

    $(document).ready(() => {
    // Remueve cualquier evento previo y asigna el nuevo
        $(document).off('submit', '#upload-form').on('submit', '#upload-form', handleFormSubmit);
    });
    window.addProduct = () => {
        const form = document.getElementById('upload-form');
        const formData = new FormData(form); // Incluye archivos automáticamente
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/requisition_rows`,
            type: "POST",
            data: formData,
            processData: false, // necesario para FormData
            contentType: false, // necesario para FormData
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                 $('#exampleModal').modal('hide');

                // Si queda alguna clase o backdrop, forzar limpieza:
                setTimeout(() => {
                    $('#exampleModal').removeClass('show').attr('aria-modal', 'false').css('display','none');
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                    $('.modal-backdrop').remove();
                    $('#exampleModal-body').html('');
                }, 250); // 250ms para dejar que la animación termine

                let dt = window.LaravelDataTables['requisition_rows-table'];
                dt.draw(false);

            snackBar(response.message, response.status ? "success" : "danger");
            },error: function(xhr, textStatus, errorThrown) {
                let message = "Ha ocurrido un error inesperado.";

                // Si el servidor envía un JSON con mensaje
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                } 
                // Si es error de validación de Laravel
                else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    message = Object.values(errors).flat().join('<br>');
                } 
                // Si no hay mensaje, mostrar el tipo de error HTTP
                else if (xhr.status) {
                    message = `Error ${xhr.status}: ${errorThrown}`;
                }

                // Mostrar en snackbar o alerta
                snackBar(message, "danger");

                // También puedes hacer console.log para depuración
                console.error("Error en addProduct:", xhr);
            
            }
        })
    }


    window.updateProduct = (requisition_row_id) => {
        const form = document.getElementById('upload-form');
        const formData = new FormData(form); // Incluye archivos automáticamente
        formData.append('_method', 'PUT');
        console.log(form)
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/requisition_rows/${requisition_row_id}`,
            type: "POST",
            data: formData,
            processData: false, // necesario para FormData
            contentType: false, // necesario para FormData
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $('#exampleModal').modal('hide');

                // Si queda alguna clase o backdrop, forzar limpieza:
                setTimeout(() => {
                    $('#exampleModal').removeClass('show').attr('aria-modal', 'false').css('display','none');
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                    $('.modal-backdrop').remove();
                    $('#exampleModal-body').html('');
                }, 250); // 250ms para dejar que la animación termine


                let dt = window.LaravelDataTables['requisition_rows-table'];
                dt.draw(false);

            snackBar(response.message, response.status ? "success" : "danger");
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        })
    }

    window.deleteRow = function (id) {

        const confirm = alertYesNo(
            'Eliminar institución',
            '¿Estás seguro de eliminar la institución?'
        );

        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/requisition_rows/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function () {
                        table.draw(false); // fuerza actualización
                        snackBar("Registro eliminado", "success");
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown);
                    }
                });
            }
        });
    };

    window.createRow = function () {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/requisition_rows/editModal`, // sin id
            type: 'GET',
            success: function (response) {
                $('#exampleModal .modal-content').html(response.html);
                $('#exampleModal').modal('show');
            }
        });
    };

    window.createModal = function () {
        const addProductBtn = document.getElementById('add_product_btn');
        const requisition_id = $("#requisition_id").val()

        // addProductBtn.setAttribute('disabled', '');
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/requisition_rows/modal/create`,
            type: 'GET',
            data: {
                "requisition_id" : requisition_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                // Inyectamos el HTML en el modal
                $('#exampleModal-body').html(response.html);

                initTotalCostListener(); 

                // Abrimos el modal
                $('#exampleModal').modal('show');
            },
            error: function (xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown);
            }
        });
    };

    window.editModal = function (id) {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/requisition_rows/modal/edit/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                // Inyectamos el HTML en el modal
                $('#exampleModal-body').html(response.html);

                initTotalCostListener(); 

                // Abrimos el modal
                $('#exampleModal').modal('show');
            },
            error: function (xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown);
            }
        });
    };

    window.showModal = function (id) {
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/requisition_rows/modal/show/${id}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                // Inyectamos el HTML en el modal
                $('#exampleModal-body').html(response.html);

                // Abrimos el modal
                $('#exampleModal').modal('show');
            },
            error: function (xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown);
            }
        });
    };

    window.approveRequisition = function (id, status) {
        const confirm = alertYesNo(
            'Aprovar requisición',
            '¿Estás seguro de aprovar la requisición?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/requisitions/change_status/${id}/${status}`,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        snackBar("Requisicón aprobada correctamente", "success")

                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    } 
                });
            }
        })
    };

    window.denyRequisition = function (id, status) {
        const confirm = alertYesNo(
            'Rechazar requisición',
            '¿Estás seguro de rechazar la requisición?'
        );
        confirm.then((result) => {
            if (result) {
                $.ajax({
                    url: $('meta[name="app-url"]').attr('content')+`/requisitions/change_status/${id}/${status}`,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        snackBar("Requisicón rechazada correctamente", "success")

                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    } 
                });
            }
        })
    };

    
    
})

window.addEventListener('beforeunload', (e) => {
    const id = document.getElementById('requisition_id').value;
    console.log(id);

    if (!formSubmitted){
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/requisitions/${id}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response){
                console.log(`Deleted requisition ${id}`);
            },
            error: function (xhr, errorThrwon){
                
            }
        });
    }
});

function initTotalCostListener() {
    const qtyInput   = document.getElementById("product_quantity");
    const costInput  = document.getElementById("product_cost");
    const ivaInput   = document.getElementById("has_iva");
    const totalInput = document.getElementById("total_cost");

    if (!qtyInput || !costInput || !ivaInput || !totalInput) return;

    function updateTotalCost() {
        let qty  = parseFloat(qtyInput.value)  || 0;
        let cost = parseFloat(costInput.value) || 0;
        let total = qty * cost;

        if (!ivaInput.checked) total *= 1.16;

        totalInput.value = total.toFixed(2);
    }

    qtyInput.addEventListener("input", updateTotalCost);
    costInput.addEventListener("input", updateTotalCost);
    ivaInput.addEventListener("change", updateTotalCost);
}