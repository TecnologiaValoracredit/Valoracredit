$(document).ready(function(){
    const user_id = $("#user_id").val()
    const promotor_id = $("#promotor_id").val()
    const coordinator_id = $("#coordinator_id").val()
    const manager_id = $("#manager_id").val()
    const requisition_id = $("#requisition_id").val()


     let table = window.LaravelDataTables['requisition_rows-table'];

    function updateAmount() {
        let columnData = table.column(4, { search: 'applied' }).data();
        let sum = columnData.reduce(function (a, b) {
            return (parseFloat(a) || 0) + (parseFloat(b) || 0);
        }, 0);
        $('#amount').val(sum.toFixed(2));
    }

    // recalcular cada vez que se redibuja la tabla
    table.on('draw', function () {
        updateAmount();
    });

    // llamar al inicio
    updateAmount();


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
                errorMessage(xhr.status, errorThrown)
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
        const requisition_id = $("#requisition_id").val()
        console.log(requisition_id);
        $.ajax({
            url: $('meta[name="app-url"]').attr('content')+`/requisition_rows/modal/create`,
            type: 'GET',
            headers: {
                'requisition_id': requisition_id,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                // Inyectamos el HTML en el modal
                $('#exampleModal-body').html(response.html);


                initTotalCostListener(); 
                $('#modal-action-btn')
                .text('Crear')
                .off('click') // quitamos cualquier evento previo
                .on('click', function () {
                    addProduct(); // función de creación
                });

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
                 $('#modal-action-btn')
                .text('Actualizar')
                .off('click')
                .on('click', function () {
                    updateProduct(id); // función de actualización
                });

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

                // initTotalCostListener(); 
                //  $('#modal-action-btn')
                // .text('Actualizar')
                // .off('click')
                // .on('click', function () {
                //     updateProduct(id); // función de actualización
                // });

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
                        // var table = window.LaravelDataTables[`institution_commission_promotors-table`];
                        // table.draw(false);
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
                        // var table = window.LaravelDataTables[`institution_commission_promotors-table`];
                        // table.draw(false);
                        snackBar("Requisicón rechazada correctamente", "success")

                    },error: function(xhr, textStatus, errorThrown) {
                        errorMessage(xhr.status, errorThrown)
                    } 
                });
            }
        })
    };

})
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

//  $(document).on('click', '.open-modal edit', function() {
//     var id = $(this).data('id');
//     document.getElementById("parent_id").value = id; // asigna al input hidden
//     console.log(id);

//     $.get('/requisition-rows/modal/' + id, function(html) {
//         $('body').append(html); // Agrega el modal al body
//         $('#exampleModal').modal('show');

//         // Opcional: remover el modal al cerrarlo para no duplicarlo
//         $('#exampleModal').on('hidden.bs.modal', function () {
//             $(this).remove();
//         });
//     });
// });

// $('#exampleModal').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget)
//     var id = button.data('id')
//     var modal = $(this)

//     if (id) {
//         $.get('/requisition_rows/editModal' + id , function(html) {
//             modal.find('#upload-form .w-75').html(html) // sustituye los fields
//             modal.find('.modal-title').text('Editar producto')
//         })
//     } else {
//         modal.find('#upload-form')[0].reset()
//         modal.find('.modal-title').text('Crear producto')
//     }
// })