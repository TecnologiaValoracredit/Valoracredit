<!-- Tipo de dispositivo, Marca y Responsable -->
<div class="row mb-2">
  <!-- Tipo de dispositivo -->
  <div class="col-md-4">
    @include("components.custom.forms.input-select", [
      "id" => "h_device_type_id",
      "name" => "h_device_type_id",
      "elements" => $h_device_types,
      "placeholder" => "Tipo de dispositivo",
      "value" => isset($h_hardware) ? $h_hardware->h_device_type_id : old("h_device_type_id"),
      "label" => "Tipo de dispositivo",
      "required" => true,
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>

  <!-- Marca -->
  <div class="col-md-4">
    @include("components.custom.forms.input-select", [
      "id" => "h_brand_id",
      "name" => "h_brand_id",
      "elements" => $h_brands,
      "placeholder" => "Marca de dispositivo",
      "value" => isset($h_hardware) ? $h_hardware->h_brand_id : old("h_brand_id"),
      "label" => "Marca de dispositivo",
      "required" => false,
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>

  <!-- Responsable -->
  <div class="col-md-4">
    @include("components.custom.forms.input-select", [
      "id" => "user_id",
      "name" => "user_id",
      "elements" => $users,
      "placeholder" => "Responsable",
      "value" => isset($h_hardware) ? $h_hardware->user_id : old("user_id"),
      "label" => "Responsable",
      "required" => true,
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>
</div>
  
  <div class="row mb-4">
    <!--Numero de serie original-->
    <div class="col-md-4">
      @include("components.custom.forms.input", [
        "id" => "serial_number",
        "name" => "serial_number",
        "type" => "text",
        "placeholder" => "Numero de serie...",
        "label" => "Numero de serie original",
        "value" => isset($h_hardware) ? $h_hardware->serial_number : old("serial_number"),
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>
    <!--Numero de serie custom-->
    <div class="col-md-4">
    <label for="custom_serial_number">Número de serie</label>
    <input 
        type="text" 
        id="custom_serial_number" 
        name="custom_serial_number" 
        value="{{ isset($h_hardware) ? $h_hardware->custom_serial_number : 'Se generará automáticamente al guardar' }}" 
        placeholder="Número de serie" 
        disabled 
        class="form-control"
    >
</div>


  
  

<!-- Número de serie original y Número de serie custom -->
<div class="row mb-4">
  <!-- Fecha de compra -->
   <div class="col-md-4">
    @include("components.custom.forms.input", [
      "id" => "purchase_date",
      "name" => "purchase_date",
      "type" => "date",
      "placeholder" => "Fecha compra",
      "label" => "Fecha compra",
      "value" => isset($h_hardware) ? $h_hardware->purchase_date : old("purchase_date"),
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>
  <!-- Número de serie original -->
  <div class="col-md-4">
    @include("components.custom.forms.input", [
      "id" => "serial_number",
      "name" => "serial_number",
      "type" => "text",
      "placeholder" => "Número de serie...",
      "label" => "Número de serie original",
      "value" => isset($h_hardware) ? $h_hardware->serial_number : old("serial_number"),
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>

  <!-- Número de serie custom -->
  <div class="col-md-4">
    @include("components.custom.forms.input", [
      "id" => "custom_serial_number",
      "name" => "custom_serial_number",
      "type" => "text",
      "label" => "Número de serie",
      "value" => isset($h_hardware) ? $h_hardware->custom_serial_number : 'Se generará automáticamente al guardar',
      "placeholder" => "Número de serie",
      "readonly" => true,
    ])
  </div>
</div>

<!-- Fecha de compra, Color y Sucursal -->
<div class="row mb-2">
  <!-- Color -->
  <div class="col-md-4">
    @include("components.custom.forms.input", [
      "id" => "color",
      "name" => "color",
      "type" => "text",
      "placeholder" => "Color",
      "label" => "Color",
      "required" => true,
      "value" => isset($h_hardware) ? $h_hardware->color : old("color"),
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>

  <!-- Sucursal -->
  <div class="col-md-4">
    @include("components.custom.forms.input-select", [
      "id" => "branch_id",
      "name" => "branch_id",
      "elements" => $branches,
      "placeholder" => "Sucursal",
      "value" => isset($h_hardware) ? $h_hardware->branch_id : old("branch_id"),
      "label" => "Sucursal",
      "required" => true,
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>
<<<<<<< HEAD
<!--Compañia-->
=======
<!-- Compañía -->
>>>>>>> 7ebb62a5c8a7a65ed9084774ac4fc6c5fbb2498a
  <div class="col-md-4">
    @include("components.custom.forms.input-select", [
      "id" => "company_id",
      "name" => "company_id",
      "elements" => $companies,
      "placeholder" => "Compañía",
      "value" => isset($h_hardware) ? $h_hardware->company_id : old("company_id"),
      "label" => "Compañía",
      "required" => true,
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>
</div>

<!-- Especificaciones -->
<div class="row mb-2">
  <div class="col-md-12">
    @include("components.custom.forms.textarea", [
      "id" => "specifications",
      "name" => "specifications",
      "placeholder" => "Agrega algún detalle o problema",
      "label" => "Especificaciones",
      "required" => false,
      "value" => isset($h_hardware) ? $h_hardware->specifications : old("specifications"),
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>
</div>

<!-- Imagen -->
<div class="row mb-4">
  <div class="col-md-4">
    <label for="image">Imagen</label>
    <input type="file" class="form-control" id="image" name="image" accept="image/*">

    <!-- Mostrar imagen actual si existe -->
    @if(isset($h_hardware) && $h_hardware->image)
      <div class="mt-2">
        <label>Imagen actual</label><br>
        <img src="{{ asset('storage/' . $h_hardware->image) }}" alt="Imagen del hardware" style="max-width: 200px; max-height: 200px;">
      </div>
    @endif
  </div>
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