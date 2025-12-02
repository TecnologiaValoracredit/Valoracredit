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