<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de permiso denagada</title>
    <style>
        
        body{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        }

        #title {
            margin-top: 50px;
            text-align: center;
        }

        .button{
            display: inline-block;
            background-color: #0000ff;
            color: #ffffff;
            font-weight: bold;
        }

        a, a:visited, a:hover, a:active{
            text-decoration: none;
            color: #ffffff;
        }
        
        ul{
            list-style:disc;
        }

    </style>
</head>
<body>
    <div id="title" class="container">
        <h1>Solicitud de permiso denegada</h1>
    </div>

    <div class="message-container">
        <p>Hola {{ $receiver_name ?? 'Usuario' }},</p>
        <p>Su solicitud generada en {{ $permit->permit_date ? date('d/m/Y') : 'Fecha' }}, fue denegada.</p>
        <p>Acceda al sitio para verificar observaciones hechas por su Jefe directo u Recursos Humanos.</p>

        <span style="display: inline-block; text-align: center; background-color: #1760ff; border: 1px solid #1760ff; color: white;">
            <span style="display: inline-block; background-color: #1760ff; color: #ffffff; border-width: 1px 0 0 1px; border-color: #1760ff; border-style: solid;">
                <a style="display: inline-block; text-decoration: none; font-weight: bold; color: #ffffff; border-color: #1760ff; border-width: 5px 10px; border-style: solid; white-space: nowrap;" href="{{ $url ?? '#' }}">Ver permiso</a>
            </span>
        </span>

        <p>Gracias, 
            <br>
            Sistema de permisos, Valora Credit
        </p>
    </div>
</body>
</html>
