@php

if (!isset($user)) return;
//Determina el folder de donde sacara las imagenes, dependiendo
//del tipo de documento dado.
$fileExtension = '';
$altText = '';

switch($type){
    case 'ine': 
    $fileExtension = 'ines';
    $altText = 'Imagen de la INE'; 
    break;

    case 'curp': 
    $fileExtension = 'curps';
    $altText = 'Imagen de la CURP'; 
    break;

    case 'address': 
    $fileExtension = 'addresses';
    $altText = 'Imagen del comprobante de domicilio'; 
    break;

    case 'birth_document': 
    $fileExtension = 'birth_docs';
    $altText = 'Imagen de la acta de nacimiento'; 
    break;

    case 'account_status': 
    $fileExtension = 'accounts';
    $altText = 'Imagen del estado de cuenta'; 
    break;
}

$path = 'storage/'.$fileExtension.'/'.$user->{'path_'.$type};
@endphp

@if ($user->{'path_'.$type})
<div>
    <a href="{{ asset($path) }}" target="_blank">
        <img src="{{ asset($path) }}" alt="{{ $altText }}"
        style="max-width: 200px; max-height: 200px;"><br>
    </a>
</div>
@endif