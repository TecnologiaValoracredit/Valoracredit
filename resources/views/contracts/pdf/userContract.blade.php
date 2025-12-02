<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato</title>
    <style>
        
        .logo {
            position: absolute;
            top: -50px;
            right: -10px;
            width: 120px;
        }

        #content {
            margin-top: 50px;
        }
        p {
            margin: 0 !important;
            padding: 0 !important;
        }
        
    </style>
</head>
<body>

    <img src="{{ public_path('images/logo 2 tintas.png') }}" class="logo">

    <div id="content">
        {!! nl2br($content) !!}
    </div>

</body>
</html>
