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

    <!-- Id -->
    <div class="col-md-3">
      <label for="sol_id" class="form-label">Id</label>
      <input type="text" id="sol_id" class="form-control" value="{{ old('sol_id', $h_brand->id ?? '') }}" disabled>
    </div>
  </div>