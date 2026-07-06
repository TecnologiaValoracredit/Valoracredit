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
        .w-20 { width: 20%; }

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
                    <th>FECHA DE CREACIÓN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisition_globals as $global)
                <tr>
                    <td class="w-20">RG-{{ $global->id ?? "NO ESPECIFICADO" }}</td>
                    <td class="w-20">
                        @foreach ($requisition_global->currenciesWithTotals() as $currency => $total)
                        <div class="d-flex justify-content-between px-3 py-2">
                            <span>{{ "Total ({$currency})" }} &dollar;{{ number_format($total, 2) }}</span><br>
                        @endforeach
                    </td>
                    <td class="w-20">
                        @foreach ($global->suppliers() as $supplier)
                            <span>{{ $supplier }}</span><br>
                        @endforeach
                    </td>
                    <td class="w-20"><a style="color: #0000ff" href="{{ route('requisition_globals.review', $global->id) ?? "#" }}">Ver más</a></td>
                    <td class="w-20">{{ date("d/m/Y", strtotime($global->application_date)) }}</td>
                </tr>
                <tr>
                    <td colspan="5" style="border-bottom: 1px solid black;"></td>
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
