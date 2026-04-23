<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Poliza de Requisición No. {{$requisition->id}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .page-center {
            text-align: center;
            margin-top: 50%;
            font-size: 2.5rem;
            font-weight: bold;
        }
        .logo {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 120px;
        }
        .file-container{
            margin: 30px auto;
            width: 450px;
            border-color: 1px solid #000000;
        }
        .evidence{
            width: 100%;
        }
    </style>
</head>
<body>

    <img src="{{ public_path('images/logo 2 tintas.png') }}" class="logo">

    <div class="page-center">Poliza de Requisición No. {{$requisition->id}}</div>

    @if (isset($encodedImages))
    
    @foreach ($encodedImages as $encodedImage)
    
    <div class="file-container">
        <img src="data:{{ $encodedImage['mime'] }};base64,{{ $encodedImage['data'] }}" alt="Image of evidence" class="evidence">
    </div>
    <br>

    @endforeach

    @endif
</body>
</html>
