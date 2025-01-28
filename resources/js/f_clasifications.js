$(function(){
  
    function toggleInputBasedOnSelect() {
        const selectedValue = $("#parent_id").val(); // Obtiene el valor actual del select
        
        if (parseInt(selectedValue) > 0) { // Si el valor es mayor a 0
            $("#f_movement_type_id").val("").prop("disabled", true); // Limpia y deshabilita el input
        } else {
            $("#f_movement_type_id").prop("disabled", false); // Habilita el input
        }
    }

    // Ejecuta la lógica al cargar la página
    toggleInputBasedOnSelect();

    // Ejecuta la lógica al cambiar el valor del select
    $("#parent_id").on("change", function() {
        toggleInputBasedOnSelect();
    });

});