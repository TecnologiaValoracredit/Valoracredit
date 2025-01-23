<div class="mb-2">
    @include("components.custom.forms.input-inline", [
        "id" => "name",
        "name" => "name",
        "type" => "string",
        "label" => "Nombre",
        "required" => true,
        "value" => isset($f_clasification) ? $f_clasification->name :  old("name"),
        "invalid_feedback" => "El campo es requerido"
    ])
</div> 
<div class= "mb-2">
    @include("components.custom.forms.input-inline-select", [
        "id" => "parent_id",
        "name" => "parent_id",
        "elements" => $f_clasifications,
        "placeholder" => "Clasificación padre",
        "value" => isset($f_clasification) ? $f_clasification->parent_id : old("parent_id"),
        "label" => "Clasificación padre",
        "invalid_feedback" => "El campo es requerido"
    ])
</div> 

    <!--Activo-->
<div class="mb-2">
    @include("components.custom.forms.input-check", [
        "id" => "is_active",
        "name" => "is_active",
        "checked" => isset($f_clasification) ? $f_clasification->is_active :  true,
        "label" => "Activo",
    ])
</div>


