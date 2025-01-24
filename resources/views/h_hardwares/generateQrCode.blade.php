<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        .container {
            width: 180px;
            height: 100px;
            padding: 5px;
            border: 1px solid #000; /* Borde más delgado */
            display: inline-block; /* Ajuste al tamaño del contenido */
            box-sizing: border-box; /* Asegura que el padding no afecte el tamaño total */
        }
        .header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            font-size: 14px; /* Tamaño de fuente más pequeño */
        }
        .header div {
            margin-right: 5px; /* Menos espacio entre número de serie, fecha y QR */
        }
        .qr {
            margin-left: 5px; /* Menos espacio entre fecha/número de serie y QR */
        }
        .qr img {
            width: 60px; /* Ajusta el tamaño del QR si es necesario */
        }
        h1 {
            font-size: 16px; /* Ajusta el tamaño del nombre si es necesario */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <p> {{ $h_hardware->custom_serial_number }}</p>
                <p> {{ \Carbon\Carbon::parse($h_hardware->purchase_date)->format('d/m/Y') }}</p>
            </div>
            <div class="qr">
                {!! $qrCode !!}
            </div>
        </div>
        <h1>{{ $h_hardware->name }}</h1>
    </div>
</body>
</html>
