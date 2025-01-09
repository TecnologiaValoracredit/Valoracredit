<div class="container mt-4">
  <!-- Sección de Datos del Solicitante -->
  <div class="row mb-4">
    <!-- Nombre del cliente -->
    <div class="col-md-7
    ">
      @include("components.custom.forms.input", [
        "id" => "client_name",
        "name" => "client_name",
        "type" => "text",
        "placeholder" => "Nombre de cliente...",
        "label" => "Nombre de cliente",
        "required" => true,
        "value" => isset($chk_checklist) ? $chk_checklist->client_name : old("client_name"),
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>

    <!-- Fecha -->
    <div class="col-md-5">
      <label for="date" class="form-label">Fecha</label>
      <input type="date" id="date" class="form-control" name="date" value="{{ old('date', $chk_checklist->date ?? '') }}">
    </div>
  </div>

  <!-- Institución -->
  <div class="row mb-4">
    <div class="col-md-9">
      @include("components.custom.forms.input-select", [
        "id" => "institution_id",
        "name" => "institution_id",
        "elements" => $institutions,
        "placeholder" => "Institución",
        "value" => isset($chk_checklist) ? $chk_checklist->institution_id : old("institution_id"),
        "label" => "Institución",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>

    <!-- Id Solicitud -->
    <div class="col-md-3">
      <label for="sol_id" class="form-label">Id Solicitud</label>
      <input type="text" id="sol_id" class="form-control" value="{{ old('sol_id', $chk_checklist->sol_id ?? '') }}" disabled>
    </div>
  </div>

  <!-- RFC -->
  <div class="row mb-4">
    <div class="col-md-9">
      @include("components.custom.forms.input", [
        "id" => "rfc",
        "name" => "rfc",
        "type" => "text",
        "placeholder" => "RFC...",
        "label" => "RFC",
        "required" => true,
        "value" => isset($chk_checklist) ? $chk_checklist->rfc : old("rfc"),
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>
  </div>

  <!-- Tipo de Crédito y Id Crédito -->
  <div class="row mb-4">
    <div class="col-md-4">
      @include("components.custom.forms.input-select", [
        "id" => "chk_credit_type_id",
        "name" => "chk_credit_type_id",
        "elements" => $chk_credit_types,
        "placeholder" => "Tipo de Crédito",
        "value" => isset($chk_checklist) ? $chk_checklist->chk_credit_type_id : old("chk_credit_type_id"),
        "label" => "Tipo de Crédito",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>

    <div class="col-md-4">
      <label for="credit_id" class="form-label">Id Crédito</label>
      <input type="text" id="credit_id" class="form-control" value="{{ old('credit_id', $chk_checklist->credit_id ?? '') }}" disabled>
    </div>
  </div>

  <!-- Monto de Crédito y Monto Dispersado -->

  
  <div class="row mb-4">
    <div class="col-md-4">
      @include("components.custom.forms.input", [
        "id" => "credit_ammount",
        "name" => "credit_ammount",
        "type" => "number",
        "placeholder" => "Monto del Crédito...",
        "label" => "Monto del Crédito",
        "required" => true,
        "value" => isset($chk_checklist) ? $chk_checklist->credit_ammount : old("credit_ammount"),
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>
  
    <div class="col-md-4">
      @include("components.custom.forms.input", [
        "id" => "dispersed_ammount",
        "name" => "dispersed_ammount",
        "type" => "number",
        "placeholder" => "Monto Dispersado...",
        "label" => "Monto Dispersado",
        "required" => true,
        "value" => isset($chk_checklist) ? $chk_checklist->dispersed_ammount : old("dispersed_ammount"),
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>
  
    <div class="col-md-4">
      @include("components.custom.forms.input-select", [
        "id" => "exp_type_id",
        "name" => "exp_type_id",
        "elements" => $exp_types,
        "placeholder" => "Tipo de Firma",
        "value" => isset($chk_checklist) ? $chk_checklist->exp_type_id : old("exp_type_id"),
        "label" => "Tipo de Firma",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
      ])
    </div>
  </div>


  <!-- Estado -->
  <div class="row mb-4">
    @foreach ($chk_lists as $chk_list)
      <hr>
      <div class="d-flex gap-2 align-items-center">
        @if (isset ($chk_checklist))
          <input type="checkbox" 
          id="chk_{{$chk_list->id}}" 
          name="chk_lists[]" 
          value="{{$chk_list->id}}"
          {{ in_array($chk_list->id, old('chk_lists', $chk_checklist->chkLists->pluck('id')->toArray())) ? 'checked' : '' }} />
        @else
        <input type="checkbox" 
          id="chk_{{$chk_list->id}}" 
          name="chk_lists[]" 
          value="{{$chk_list->id}}"/>
        @endif
       
        <label for="chk_{{$chk_list->id}}" class="m-0">{{$chk_list->description}}</label>
      </div>
    @endforeach
  </div>

  <!-- Botón activo -->
  <div class="mb-2">
    @include("components.custom.forms.input-check", [
      "id" => "is_active",
      "name" => "is_active",
      "checked" => isset($chk_checklist) ? $chk_checklist->is_active : true,
      "label" => "Activo",
    ])
  </div>
</div>