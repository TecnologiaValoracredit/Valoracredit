<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
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
        
        ul {
            list-style:disc;
        }

        th, td {
            text-align: left;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        .notes {
            white-space: normal;
            overflow-wrap: break-word;
        }
        
        .w-15 { width: 15%; }
        .w-25 { width: 25%; }

        .approved { color: #008000; }
        .denied { color: #ff0000; }
        .returned { color: #ff8800; }
    </style>
</head>
<body>

    <div id="title" class="container">
        <h1>{{ $title }}</h1>
    </div>

    <div class="message-container">
        <p>Hola D.G.,</p>
        <p>Las siguientes requisiciones requiren de su revisión.</p>
        <p>Accedan al sitio para ver más acerca de cada una, o presione en "Ver más" de cada una para acceder directamente.</p>

        <table>
            <thead>
                <tr>
                    <th>FOLIO</th>
                    <th>TOTAL</th>
                    <th>PROVEEDORES</th>
                    <th>ORIGEN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisition_globals as $global)
                <tr>
                    <td class="w-25">RG-{{ $global->id ?? "NO ESPECIFICADO" }}</td>
                    <td class="w-25">{{ number_format($global->totalGlobalAmount(), 2) ?? "NO ESPECIFICADO" }}</td>
                    <td class="w-25">
                        @foreach ($global->suppliers() as $supplier)
                            <span>{{ $supplier }}</span><br>
                        @endforeach
                    </td>
                    <td class="w-25"><a style="color: #0000ff" href="{{ route('requisition_globals.review', $global->id) ?? "#" }}">Ver más</a></td>
                </tr>
                <tr>
                    <td colspan="4" style="border-bottom: 1px solid black;"></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 30px">
            <span style="display: inline-block; text-align: center; background-color: #1760ff; border: 1px solid #1760ff; color: white;">
                <span style="display: inline-block; background-color: #1760ff; color: #ffffff; border-width: 1px 0 0 1px; border-color: #1760ff; border-style: solid;">
                    <a style="display: inline-block; text-decoration: none; font-weight: bold; color: #ffffff; border-color: #1760ff; border-width: 5px 10px; border-style: solid; white-space: nowrap;"
                    href="{{ $url ?? '#' }}">Ir a Requisiciones Globales</a>
                </span>
            </span>
        </div>

        <p>Gracias, 
            <br>
            Sistema Valora Credit
        </p>
    </div>

</body>
</html>
