<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Requisición Global No.{{$requisition_global->id}} - {{ $requisitionGlobalStatus->name }}</title>
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
        .next-page{
            page-break-after: always;
        }
    </style>
</head>
<body>

    <img src="{{ public_path('images/logo 2 tintas.png') }}" class="logo">

    <h2 class="center">Requisición Global No.{{$requisition_global->id}} - {{ $requisitionGlobalStatus->name }}</h2>

    <h3 style="margin-top: 40px">WS PROMOTORA SAPI DE CV</h3>
    <h3>SOLICITUD DE AUTORIZACIÓN DE PAGOS</h3>

    <table class="no-border">
        <tr>
            <td style="width: 50%;">
                <table>
                    <tr>
                        <td><strong>Fecha de solicitud:</strong></td>
                        <td>{{ date("d-m-Y",strtotime(($requisition_global->created_at))) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de aplicación:</strong></td>
                        <td>{{ date("d-m-Y",strtotime(($requisition_global->application_date))) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total:</strong></td>
                        <td>&dollar;{{ number_format($requisition_global->totalGlobalAmount(), 2) ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <table>
                    <tr>
                        <td><strong>Solicita:</strong></td>
                        <td>{{ $requisition_global->creator->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Provisiona:</strong></td>
                        <td>Francisco Sánchez</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 20px">Proveedores</h3>

    <table class="table">
        <thead>
            <th class="section-title">Nombre</th>
            <th class="section-title">Importe</th>
        </thead>

        <tbody>
            @foreach ($requisition_global->suppliersWithTotals() as $supplier => $total )
                <tr>
                    <td>{{ $supplier }}</td>
                    <td>{{ $total }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="bold right-text">Total:</td>
                <td>&dollar;{{ number_format($requisition_global->totalGlobalAmount(), 2) ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- TABLA DE FIRMAS -->
    <table class="bottom-fixed" style="table-layout: fixed;">
        <tr>
            <td class="signature-box">
                @if ($requisition->roleApprovedApproval('Dirección general'))
                    <img src="{{ storage_path("app/public/{$requisition->roleApprovedApproval('Dirección general')->user->path_signature}") }}" alt="Firma de Dirección general" class="signature-img">                
                @endif
            </td>
            <td class="signature-box">
                @if ($requisition->adminSignatureApproval())
                    <img src="{{ storage_path("app/public/{$requisition->adminSignatureApproval()->user->path_signature}") }}" alt="Firma de Contabilidad" class="signature-img">
                @elseif($requisition->roleApprovedApproval('Contabilidad'))
                    <img src="{{ storage_path("app/public/{$requisition->roleApprovedApproval('Contabilidad')->user->path_signature}") }}" alt="Firma de Contabilidad" class="signature-img">
                @endif
            </td>
            <td class="signature-box">
                @if ($requisition_global->creator->path_signature)
                    <img src="{{ storage_path("app/public/{$requisition_global->creator->path_signature}") }}" alt="Firma del solicitante" class="signature-img">                
                @endif
            </td>
        </tr>
        <tr class="no-boder">
            <td class="center">
                {{ $requisition->roleApprovedApproval('Dirección general')->user->name ?? '' }}
                <br>
                <strong>Firma de Dirección general</strong>
            </td>
            <td class="center">
                @if ($requisition->adminSignatureApproval())
                    {{ $requisition->adminSignatureApproval()->user->name ?? '' }}
                @elseif($requisition->roleApprovedApproval('Contabilidad'))
                    {{ $requisition->roleApprovedApproval('Contabilidad')->user->name ?? '' }}
                @endif
                <br>
                <strong>Firma de Administración</strong>
            </td>
            <td class="center">
                {{ $requisition_global->creator->name ?? '' }}
                <br>
                <strong>Firma del solciitante</strong>
            </td>
        </tr>
    </table>

    <div class="next-page"></div>

    <h3 style="margin-top: 20px">Desglose por Tipo de gastos</h3>

    @foreach ($requisition_global->expenseTypes() as $key => $value)
    <table>
        <thead>
            <tr>
                <th class="section-title center" colspan="4">{{ $value }}</th>
            </tr>
            <tr>
                <th class="section-title">Folio</th>
                <th class="section-title">Concepto de pago</th>
                <th class="section-title">Importe</th>
                <th class="section-title">Cuenta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requisition_global->getRequisitionsByExpenseType($key) as $requisition)
               <tr>
                <td>{{ $requisition->folio }}</td>
                <td>
                    <table class="no-border">
                        @foreach ($requisition->requisitionRows as $row)
                           <tr>
                                <td><b>Concepto:</b> {{ $row->product }}</td>
                            </tr> 
                           <tr>
                                <td><b>Periodo:</b> {{ $row->getPeriod() }}</td>
                            </tr> 
                           <tr>
                                <td><b>Monto:</b> {{ number_format($row->total_cost) }}</td>
                            </tr> 
                        @endforeach
                    </table>
                </td>
                <td>{{ $requisition->amount }}</td>
                <td>{{ $requisition->bank->name }}</td>
                </tr> 
            @endforeach
        </tbody>
    </table>
    @endforeach
</body>
</html>
