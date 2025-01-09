  
  <!-- Tipo de dispositivo -->
  <div class="row mb-4">
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
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>
 
  <!--Responsable-->
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
        "required" => true,
        "value" => isset($h_hardware) ? $h_hardware->serial_number : old("serial_number"),
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>
    <!--Numero de serie custom-->
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
  
  

  <!--Fecha de compra-->
  <div class="col-md-4">
    @include("components.custom.forms.input", [
      "id" => "purchase_date",
      "name" => "purchase_date",
      "type" => "date",
      "placeholder" => "Fecha compra",
      "label" => "Fecha compra",
      "required" => true,
      "value" => isset($h_hardware) ? $h_hardware->purchase_date : old("purchase_date"),
      "invalid_feedback" => "El campo es requerido"
    ])
  </div>

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
  </div>       

      <!--Especificaciones-->
      <div class="col-md-12">
        @include("components.custom.forms.textarea", [
            "id" => "specifications",
            "name" => "specifications",
            "placeholder" => "Agrega algun detalle o problema",
            "label" => "Especificaciones",
            "required" => true,
            "value" => isset($h_hardware) ? $h_hardware->specifications : old("specifications"),
            "invalid_feedback" => "El campo es requerido"
        ])
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

<!--Activo-->
<div class="mb-2">
  @include("components.custom.forms.input-check", [
      "id" => "is_active",
      "name" => "is_active",
      "checked" => isset($user) ? $user->is_active :  true,
      "label" => "Activo",
  ])
</div>

      



