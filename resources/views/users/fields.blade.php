{{-- Datos personales --}}
<div class="row mb-2 mt-1 gy-3">

    <div class="mb-1">
        DATOS PERSONALES
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "name",
            "name" => "name",
            "type" => "text",
            "placeholder" => "Nombre...",
            "label" => "Nombre",
            "required" => true,
            "value" => isset($user) ? $user->name :  old("name"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "email",
            "name" => "email",
            "type" => "email",
            "placeholder" => "Email...",
            "value" => isset($user) ? $user->email :  old("email"),
            "label" => "Email",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "phone",
            "name" => "phone",
            "type" => "phone",
            "placeholder" => "Telefono...",
            "value" => isset($user) ? $user->phone :  old("phone"),
            "label" => "Telefono",
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "emergency_phone",
            "name" => "emergency_phone",
            "type" => "phone",
            "placeholder" => "Telefono...",
            "value" => isset($user) ? $user->emergency_phone :  old("emergency_phone"),
            "label" => "Telefono de emergencia",
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "birthday",
            "name" => "birthday",
            "type" => "date",
            "placeholder" => "Fecha de nacimiento...",
            "value" => isset($user) ? $user->birthday :  old("birthday"),
            "label" => "Fecha de nacimiento",
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "password",
            "name" => "password",
            "type" => "password",
            "placeholder" => "Contraseña...",
            "label" => "Contraseña",
        ])
    </div>


    <div class="col-6">
        @include("components.custom.forms.input-select", [
            "id" => "role_id",
            "name" => "role_id",
            "elements" => $roles,
            "placeholder" => "Descripción...",
            "value" => isset($user) ? $user->role_id :  old("role_id"),
            "label" => "Rol",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

</div>

{{-- Datos laborales --}}
<br>

<div class="row mb-2 gy-3">

    <div class="mb-1">
        DATOS LABORALES
    </div>

    <div class="col-6">
    @include("components.custom.forms.input-select", [
        "id" => "departament_id",
        "name" => "departament_id",
        "elements" => $departaments,
        "placeholder" => "Departamento...",
        "value" => isset($user) ? $user->departament_id :  old("departament_id"),
        "label" => "Departamento",
        "required" => true,
        "invalid_feedback" => "El campo es requerido"
    ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input-select", [
            "id" => "position_id",
            "name" => "position_id",
            "elements" => $job_positions,
            "placeholder" => "Puesto de trabajo...",
            "value" => isset($user) ? $user->position_id :  old("position_id"),
            "label" => "Puesto de trabajo",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input-select", [
            "id" => "branch_id",
            "name" => "branch_id",
            "elements" => $branches,
            "placeholder" => "Descripción...",
            "value" => isset($user) ? $user->branch_id :  old("branch_id"),
            "label" => "Sucursal",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "entry_date",
            "name" => "entry_date",
            "type" => "date",
            "placeholder" => "Fecha de entrada...",
            "value" => isset($user) ? $user->entry_date :  old("entry_date"),
            "label" => "Fecha de entrada",
        ])
    </div>

     <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "resignation_date",
            "name" => "resignation_date",
            "type" => "date",
            "placeholder" => "Fecha de salida...",
            "value" => isset($user) ? $user->resignation_date :  old("resignation_date"),
            "label" => "Fecha de salida",
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input-select", [
            "id" => "boss_id",
            "name" => "boss_id",
            "elements" => $users,
            "placeholder" => "Puesto de trabajo...",
            "value" => isset($user) ? $user->boss_id :  old("boss_id"),
            "label" => "Jefe directo",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "salary",
            "name" => "salary",
            "type" => "numeric",
            "placeholder" => "Salario...",
            "label" => "Salario",
            "value" => isset($user) ? $user->salary :  old("salary"),
        ])
    </div>

</div>

{{-- Datos Bancarios--}}
<br>

<div class="row mb-2 gy-3">

    <div class="mb-1">
        DATOS BANCARIOS
    </div>

    <div class="col-4">
         @include("components.custom.forms.input-select", [
            "id" => "bank_id",
            "name" => "bank_id",
            "elements" => $banks,
            "placeholder" => "Selecciona el banco...",
            "value" => isset($user) ? $user->bank_id :  old("bank_id"),
            "label" => "Banco",
        ])
    </div>
    <div class="col-8">
        @include("components.custom.forms.input", [
            "id" => "bank_account",
            "name" => "bank_account",
            "type" => "numeric",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Cuenta bancaria",
            "value" => isset($user) ? $user->bank_account :  old("bank_account"),
        ])
    </div>
</div>

{{-- DOCUMENTOS ANEXADOS--}}
<br>

<div class="row mb-2 gy-3">

    <div class="mb-1">
        DOCUMENTOS ANEXADOS
    </div>

    <!-- INE -->
    <div class="col-6">
        @include('components.custom.forms.input', [
            "id" => "ine",
            "name" => "ine",
            "type" => "file",
            "placeholder" => "INE...",
            "label" => "INE",
            "value" => old("ine"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'ine'
        ])
    </div>

    <!-- CURP -->
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "curp",
            "name" => "curp",
            "type" => "file",
            "placeholder" => "CURP...",
            "label" => "CURP",
            "value" => old("curp"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'curp'
        ])
    </div>

    <!-- ADRESS -->
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "address",
            "name" => "address",
            "type" => "file",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Comprobante de domicilio",
            "value" => old("address"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'address'
        ])
    </div>

    <!-- BIRTH DOCUMENT -->
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "birth_document",
            "name" => "birth_document",
            "type" => "file",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Acta de nacimiento",
            "value" => old("birth_document"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'birth_document'
        ])
    </div>

    <!-- ACCOUNT STATUS -->
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "account_status",
            "name" => "account_status",
            "type" => "file",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Estado de cuenta",
            "value" => old("account_status"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'account_status'
        ])
    </div>
</div>