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
        @include("components.custom.forms.input", [
            "id" => "phone",
            "name" => "phone",
            "type" => "number",
            "placeholder" => "Telefono...",
            "value" => isset($user) ? $user->phone :  old("phone"),
            "label" => "Telefono",
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "emergency_phone",
            "name" => "emergency_phone",
            "type" => "number",
            "placeholder" => "Telefono...",
            "value" => isset($user) ? $user->emergency_phone :  old("emergency_phone"),
            "label" => "Telefono de emergencia",
        ])
    </div>

</div>

{{-- Datos domiciliarios --}}
<br>

<div class="row mt-2 mb-2 gy-3">
    <div class="mb-1">
        DATOS LEGALES
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "curp",
            "name" => "curp",
            "type" => "text",
            "placeholder" => "CURP...",
            "label" => "Clave Unica de Registro de Población",
            "required" => true,
            "value" => isset($user) ? $user->curp :  old("curp"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "rfc",
            "name" => "rfc",
            "type" => "text",
            "placeholder" => "RFC...",
            "label" => "Registro Federal de Contribuyentes",
            "required" => true,
            "value" => isset($user) ? $user->rfc :  old("rfc"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "nss",
            "name" => "nss",
            "type" => "text",
            "placeholder" => "NSS...",
            "label" => "Numero de Seguro Social",
            "required" => true,
            "value" => isset($user) ? $user->nss :  old("nss"),
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="col-4">
         @include("components.custom.forms.input-select", [
            "id" => "gender_id",
            "name" => "gender_id",
            "elements" => $genders,
            "placeholder" => "Selecciona el genero...",
            "value" => isset($user) ? $user->gender_id :  old("gender_id"),
            "label" => "Genero",
        ])
    </div>

    <div class="col-4">
         @include("components.custom.forms.input-select", [
            "id" => "civil_status_id",
            "name" => "civil_status_id",
            "elements" => $civilStatuses,
            "placeholder" => "Selecciona el estado civil...",
            "value" => isset($user) ? $user->civil_status_id :  old("civil_status_id"),
            "label" => "Estado civil",
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "birthday",
            "name" => "birthday",
            "type" => "date",
            "placeholder" => "Fecha de nacimiento...",
            "value" => isset($user) ? $user->birthday :  old("birthday"),
            "label" => "Fecha de nacimiento",
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "birthplace",
            "name" => "birthplace",
            "type" => "text",
            "placeholder" => "Lugar de nacimiento...",
            "value" => isset($user) ? $user->birthplace :  old("birthplace"),
            "label" => "Lugar de nacimiento",
        ])
    </div>
</div>


{{-- Datos domiciliarios --}}
<br>

<div class="row mt-2 mb-2 gy-3">

    <div class="mb-1">
        DATOS DOMICILIARIOS
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "residential_address",
            "name" => "residencial_address",
            "type" => "text",
            "placeholder" => "Calle y numero...",
            "value" => isset($user) ? $user->residential_address :  old("residential_address"),
            "label" => "Domicilio",
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "colony",
            "name" => "colony",
            "type" => "text",
            "placeholder" => "Colonia...",
            "value" => isset($user) ? $user->colony :  old("colony"),
            "label" => "Colonia",
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "municipality",
            "name" => "municipality",
            "type" => "text",
            "placeholder" => "Municipio...",
            "value" => isset($user) ? $user->municipality :  old("municipality"),
            "label" => "Municipio",
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "postal_code",
            "name" => "postal_code",
            "type" => "number",
            "placeholder" => "Codigo postal...",
            "value" => isset($user) ? $user->postal_code :  old("postal_code"),
            "label" => "Codigo Postal",
        ])
    </div>
</div>

{{-- Datos laborales --}}
<br>

<div class="row mt-2 mb-2 gy-3">

    <div class="mb-1">
        DATOS LABORALES
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "employee_number",
            "name" => "employee_number",
            "type" => "number",
            "placeholder" => "Numero de empleado...",
            "value" => isset($user) ? $user->employee_number :  old("employee_number"),
            "label" => "Numero de empleado",
        ])
    </div>

    <div class="col-4">
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

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "entry_date",
            "name" => "entry_date",
            "type" => "date",
            "placeholder" => "Fecha de entrada...",
            "value" => isset($user) ? $user->entry_date :  old("entry_date"),
            "label" => "Fecha de entrada",
        ])
    </div>

    <div class="col-4">
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

    <div class="col-4">
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

    <div class="col-4">
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

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "salary",
            "name" => "salary",
            "type" => "number",
            "placeholder" => "Salario...",
            "label" => "Salario",
            "value" => isset($user) ? $user->salary :  old("salary"),
        ])
    </div>

    <div class="col-8">
        @include("components.custom.forms.input", [
            "id" => "other_benefits",
            "name" => "other_benefits",
            "type" => "text",
            "placeholder" => "Otras prestaciones...",
            "label" => "Otras prestaciones",
            "value" => isset($user) ? $user->other_benefits :  old("other_benefits"),
        ])
    </div>

</div>

{{-- Datos Bancarios--}}
<br>

<div class="row mt-2 mb-2 gy-3">

    <div class="mb-1">
        DATOS BANCARIOS
    </div>

    <div class="col-12">
         @include("components.custom.forms.input-select", [
            "id" => "bank_id",
            "name" => "bank_id",
            "elements" => $banks,
            "placeholder" => "Selecciona el banco...",
            "value" => isset($user) ? $user->bank_id :  old("bank_id"),
            "label" => "Banco",
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "bank_account",
            "name" => "bank_account",
            "type" => "number",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Cuenta bancaria",
            "value" => isset($user) ? $user->bank_account :  old("bank_account"),
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "interbank_code",
            "name" => "interbank_code",
            "type" => "number",
            "placeholder" => "Clabe interbancaria...",
            "label" => "Clabe interbancaria",
            "value" => isset($user) ? $user->interbank_code :  old("interbank_code"),
        ])
    </div>

    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "plastic_number",
            "name" => "plastic_number",
            "type" => "number",
            "placeholder" => "Numero de plastico...",
            "label" => "Numero de plastico",
            "value" => isset($user) ? $user->plastic_number :  old("plastic_number"),
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "infonavit_credit_number",
            "name" => "infonavit_credit_number",
            "type" => "number",
            "placeholder" => "Numero de credito Infonavit...",
            "label" => "Numero de credito infonavit",
            "value" => isset($user) ? $user->infonavit_credit_number :  old("infonavit_credit_number"),
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "discount_factor",
            "name" => "discount_factor",
            "type" => "number",
            "placeholder" => "Factor descuento...",
            "label" => "Factor descuento",
            "value" => isset($user) ? $user->discount_factor :  old("discount_factor"),
        ])
    </div>

    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "fonacot_credit_number",
            "name" => "fonacot_credit_number",
            "type" => "number",
            "placeholder" => "Numero de credito Fonacot...",
            "label" => "Numero de credito Fonacot",
            "value" => isset($user) ? $user->fonacot_credit_number :  old("fonacot_credit_number"),
        ])
    </div>
    
    <div class="col-6">
        @include("components.custom.forms.input", [
            "id" => "food_pension",
            "name" => "food_pension",
            "type" => "number",
            "placeholder" => "Pensión alimenticia...",
            "label" => "Pensión alimenticia",
            "value" => isset($user) ? $user->food_pension :  old("food_pension"),
        ])
    </div>
</div>

{{-- DOCUMENTOS ANEXADOS--}}
<br>

<div class="row mt-2 mb-2 gy-3">

    <div class="mb-1">
        DOCUMENTOS ANEXADOS
    </div>

    <!-- INE -->
    <div class="col-4">
        @include('components.custom.forms.input', [
            "id" => "ine_file",
            "name" => "ine_file",
            "type" => "file",
            "placeholder" => "INE...",
            "label" => "INE",
            "value" => old("ine_file"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'ine'
        ])
    </div>

    <!-- CURP -->
    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "curp_file",
            "name" => "curp_file",
            "type" => "file",
            "placeholder" => "CURP...",
            "label" => "CURP",
            "value" => old("curp_file"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'curp'
        ])
    </div>

    <!-- ADRESS -->
    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "address_file",
            "name" => "address_file",
            "type" => "file",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Comprobante de domicilio",
            "value" => old("address_file"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'address'
        ])
    </div>

    <!-- BIRTH DOCUMENT -->
    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "birth_document_file",
            "name" => "birth_document_file",
            "type" => "file",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Acta de nacimiento",
            "value" => old("birth_document_file"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'birth_document'
        ])
    </div>

    <!-- ACCOUNT STATUS -->
    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "account_status_file",
            "name" => "account_status_file",
            "type" => "file",
            "placeholder" => "Cuenta bancaria...",
            "label" => "Estado de cuenta",
            "value" => old("account_status_file"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'account_status'
        ])
    </div>

    <!-- RFC -->
    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "rfc_file",
            "name" => "rfc_file",
            "type" => "file",
            "placeholder" => "RFC...",
            "label" => "RFC",
            "value" => old("rfc_file"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'rfc'
        ])
    </div>

    <!-- NSS -->
    <div class="col-4">
        @include("components.custom.forms.input", [
            "id" => "nss_file",
            "name" => "nss_file",
            "type" => "file",
            "placeholder" => "NSS...",
            "label" => "NSS",
            "value" => old("nss_file"),
            "accept" => "image/*,.pdf"
        ])

        @include('components.custom.user-file-verification',[
            'type' => 'nss'
        ])
    </div>
</div>