
<!-- LLENA EL CAMPO DE NOMBRE DE SOLICITANTE AUTOMATICAMENTE EN BASE AL NOMBRE DEL USER -->
<div class="row align-items-start">
<div class="row mb-4">
  <div class="col-md-4">
      <label for="inputIzquierda" class="form-label">Solicitante</label>
      <input type="text" id="user" class="form-control" value= "{{ Auth::user()->name }}"  disabled>
  </div>
  <!-- EN EL ESPACIO DEL BOTON DESPLIEGA EL MENU PARA ELEGIR UN DEPARTAMENTO YA REGISTARDO  -->

  <div class="col-4">
    <label for="inputIzquierda" class="form-label">Departamento</label>
    <input type="text" id="departament" class="form-control" 
      value="{{ Auth::user()->departament ? Auth::user()->departament->name : 'No asignada' }}" disabled>
  </div>

<!-- SE AGREGA LA FECHA ACTUAL DE MANERA AUTOMATICA  -->

  <div class="col-md-4">
    <label for="fecha" class="form-label">Fecha</label>
    <input type="text" id="fecha" class="form-control" value="{{ date('d-m-Y') }}" disabled>
    <input type="hidden" name="fecha" value="{{ date('d-m-Y') }}">
</div>
  </div>
</div>

<div class="container text-center">
  <div class="row align-items-end">
<div class="col-md-4">
  @include("components.custom.forms.input-select", [
      "id" => "payment_type_id",
      "name" => "payment_type_id",
      "elements" => $payment_types,
      "placeholder" => "Método de pago...",
      "value" => isset($paymenttype) ? $paymenttype->name:  old("payment_type_id"),
      "label" => "Método de pago",
      "required" => true,
      "invalid_feedback" => "El campo es requerido"
  ])
</div>

<div class="col-4">
  <label for="inputIzquierda" class="form-label">Sucursal</label>
  <input type="text" id="branch" class="form-control" 
    value="{{ Auth::user()->branch ? Auth::user()->branch->name : 'No asignada' }}" disabled>
</div>

  @include("components.custom.forms.input-select", [
      "id" => "supplier_id",
      "name" => "supplier_id",
      "elements" => $suppliers,
      "placeholder" => "Proveedor",
      "value" => isset($supplier) ? $supplier->name:  old("supplier_id"),
      "label" => "Proveedor",
      "required" => true,
      "invalid_feedback" => "El campo es requerido"
  ])

<div class="mb-2">
  @include("components.custom.forms.input-check", [
      "id" => "is_active",
      "name" => "is_active",
      "checked" => isset($user) ? $user->is_active :  true,
      "label" => "Activo",
  ])
</div>

