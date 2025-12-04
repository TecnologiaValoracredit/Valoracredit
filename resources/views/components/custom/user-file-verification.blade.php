@php
if (!isset($user)) return;

$altText = '';
switch($type){
    case 'ine': 
    $altText = 'Imagen de la INE'; 
    break;

    case 'curp': 
    $altText = 'Imagen de la CURP'; 
    break;

    case 'address': 
    $altText = 'Imagen del comprobante de domicilio'; 
    break;

    case 'birth_document': 
    $altText = 'Imagen de la acta de nacimiento'; 
    break;

    case 'account_status': 
    $altText = 'Imagen del estado de cuenta'; 
    break;

    case 'rfc': 
    $altText = 'Imagen del estado del rfc'; 
    break;

    case 'nss': 
    $altText = 'Imagen del estado del nss'; 
    break;
}

$filePath = 'path_'. $type;
$path = 'storage/' . $user->{$filePath};
$fileFormat = substr($path, -3);
@endphp

@if ($user->{$filePath})
    <div id={{ $filePath }} class="mt-2 d-flex flex-column justify-content-center align-items-center gap-3">
        <a href="{{ asset($path) }}" target="_blank" 
        class="link-primary fs-5 text-center">
            @if ($fileFormat == 'pdf')
                Presiona aqui para visualizar el documento PDF en una nueva pestaña
            @else
                <img src="{{ asset($path) }}" alt="{{ $altText }}"
                style="max-width: 200px; max-height: 200px;"><br>
            @endif
        </a>
        <a onclick="deleteSavedFile('{{ $user->id }}', '{{ $filePath }}')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
        </a>
    </div>
@endif