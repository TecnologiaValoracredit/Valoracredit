<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta QR</title>
    <style>
        .container {
            width: 240px; /* Ancho de la etiqueta */
            height: 140px; /* Alto de la etiqueta */
            padding: 10px;
            border: 1px solid #000; /* Borde negro */
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: Arial, sans-serif; /* Fuente estándar */
            font-size: 12px; /* Tamaño del texto */
            box-sizing: border-box;
            background-color: #fff;
        }
        .info {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            line-height: 1.4;
            width: 60%; /* Asegura que la información ocupe el espacio adecuado */
            padding-right: 10px; /* Añadido para separar del QR */
        }
        .qr {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 35%; /* Asegura que el código QR ocupe el espacio adecuado */
        }
        .qr img {
            width: 80px; /* Tamaño ajustado del código QR */
            height: 80px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="info">
            <p><strong>SN:</strong> {{ $h_hardware->custom_serial_number }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($h_hardware->purchase_date)->format('d/m/Y') }}</p>
        </div>
        <div class="qr">
            <img src="{{ $qrUrl }}" alt="Código QR">
        </div>
    </div>     
</body>
</html>
