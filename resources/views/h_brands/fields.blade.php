<div class="row mb-4">
<div class="col-md-7">
  @include("components.custom.forms.input", [
    "id" => "name",
    "name" => "name",
    "type" => "text",
    "placeholder" => "Nombre de la marca",
    "label" => "Nombre de la marca",
    "required" => true,
    "value" => isset($h_brand) ? $h_brand->name : old("name"),
    "invalid_feedback" => "El campo es requerido"
  ])
</div>

    <!-- Activo -->
<div class="mb-2">
  @include("components.custom.forms.input-check", [
    "id" => "is_active",
    "name" => "is_active",
    "checked" => isset($h_hardware) ? $h_hardware->is_active : true,
    "label" => "Activo",
  ])
</div>