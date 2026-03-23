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
        .center {
            text-align: center;
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

    <h2 class="center">Poliza de Requisición No. {{$requisition->id}}</h2>

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
