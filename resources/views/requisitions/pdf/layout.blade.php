<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{$requisition->folio}} - {{ $requisition->lastLog->toStatusId->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 15px;
        }
        td, th {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            
        }
        .no-border td {
            border: none;
        }
        .section-title {
            font-weight: bold;
            background: #f2f2f2;
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
        .right-text{
            text-align: right;
        }
        .observations{
            border: 1px solid #000;
            height: 80px;
            padding: 5px;
        }
        .signature-box{
            text-align: center;
            vertical-align: middle;
            width: 200px;
            height: 200px;
        }
        .signature-img{
            max-width: 150px;
        }
        .bold{
            font-weight: bold;
        }
        .bottom-fixed{
            position: absolute;
            bottom: 250px;
        }
    </style>
</head>
<body>

    <img src="{{ public_path('images/logo 2 tintas.png') }}" class="logo">

    <h2 class="center">{{$requisition->folio}} - {{ $requisition->lastLog->toStatusId->name }}</h2>

    <h3 style="margin-top: 40px">Datos</h3>

    <table class="no-border">
        <tr>
            <td style="width: 50%;">
                <table>
                    <tr>
                        <td class="bold" colspan="2" style="text-align: center;" >Datos del solicitante</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de solicitud:</strong></td>
                        <td>{{ date("d-m-Y",strtotime(($requisition->request_date))) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nombre del Solicitante:</strong></td>
                        <td>{{ $requisition->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Departamento:</strong></td>
                        <td>{{ $requisition->departament->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Sucursal:</strong></td>
                        <td>{{ $requisition->user->branch->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jefe Inmediato:</strong></td>
                        <td>{{ $requisition->boss->name ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <table>
                    <tr>
                        <td class="bold" colspan="2" style="text-align: center;">Datos de la requisición</td>
                    </tr>
                    <tr>
                        <td><strong>Proveedor:</strong></td>
                        <td>{{ $requisition->supplier->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tipo de Gasto:</strong></td>
                        <td>{{ $requisition->expenseType->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tipo de pago:</strong></td>
                        <td>{{ $requisition->paymentType->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Cuenta:</strong></td>
                        <td>{{ $requisition->bank->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td>&dollar;{{ number_format($requisition->amount, 2) ?? '' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 20px">Productos</h3>

    <table class="table">
        <thead>
            <th class="section-title">Producto</th>
            <th class="section-title">Cantidad</th>
            <th class="section-title">Incluye IVA</th>
            <th class="section-title">Precio Unitario</th>
            <th class="section-title">Tipo de moneda</th>
            <th class="section-title">Total</th>
        </thead>

        <tbody>
            @foreach ($requisition->requisitionRows as $row )
                <tr>
                    <td>{{ $row->product }}</td>
                    <td>{{ $row->product_quantity }}</td>
                    <td>{{ $row->has_iva ? "SI" : "NO ({{ $row->iva_percentage }})" }}</td>
                    <td>&dollar;{{ number_format($row->product_cost, 2) }}</td>
                    <td>{{ $row->currencyType->name }}</td>
                    <td>&dollar;{{ number_format($row->total_cost, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="margin-top: 80px">Notas</h3>
    <p>{{ $requisition->notes ?? '' }}</p>

    @if ($hasNotes)        
        <h3 style="margin-top: 20px">Notas de ultima acción</h3>
        <p>{{ $notes ?? '' }}</p>
    @endif


    <!-- TABLA DE FIRMAS -->
    <table class="bottom-fixed" style="table-layout: fixed;">
        <tr>
            <td class="signature-box">
                @if ($requisition->boss)
                    <img src="{{ storage_path("app/public/{$requisition->boss->path_signature}") }}" alt="Firma de Jefe Inmediato" class="signature-img">                
                @endif
            </td>
            <td class="signature-box">
                @if ($requisition->user)
                    <img src="{{ storage_path("app/public/{$requisition->user->path_signature}") }}" alt="Firma de Solicitante" class="signature-img">                
                @endif
            </td>
            <td class="signature-box">
                @if ($requisition->adminSignatureApproval())
                    <img src="{{ storage_path("app/public/{$requisition->adminSignatureApproval()->user->path_signature}") }}" alt="Firma de Contabilidad" class="signature-img">
                @elseif($requisition->roleApprovedApproval('Contabilidad'))
                    <img src="{{ storage_path("app/public/{$requisition->roleApprovedApproval('Contabilidad')->user->path_signature}") }}" alt="Firma de Contabilidad" class="signature-img">
                @elseif($requisition->roleApprovedApproval('Administración'))
                    <img src="{{ storage_path("app/public/{$requisition->roleApprovedApproval('Administración')->user->path_signature}") }}" alt="Firma de Administración" class="signature-img">
                @endif
            </td>
        </tr>
        <tr class="no-boder">
            <td class="center">
                {{ $requisition->boss->name ?? '' }}
                <br>
                <strong>Firma de Jefe Inmediato</strong>
            </td>
            <td class="center">
                {{ $requisition->user->name ?? '' }}
                <br>
                <strong>Firma de solicitante</strong>
            </td>
            <td class="center">
                @if ($requisition->adminSignatureApproval())
                    {{ $requisition->adminSignatureApproval()->user->name ?? '' }}
                @elseif($requisition->roleApprovedApproval('Contabilidad'))
                    {{ $requisition->roleApprovedApproval('Contabilidad')->user->name ?? '' }}
                @elseif($requisition->roleApprovedApproval('Administración'))
                    {{ $requisition->roleApprovedApproval('Administración')->user->name ?? '' }}
                @endif
                <br>
                <strong>Firma de Contabilidad / Administración</strong>
            </td>
        </tr>
    </table>
</body>
</html>
