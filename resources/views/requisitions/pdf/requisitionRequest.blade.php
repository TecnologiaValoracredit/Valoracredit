<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Requisición de Compra  {{$requisition->id}}</title>
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
        .col-reason {
            width: 150px; 
            word-wrap: break-word;
            word-break: break-word;
            white-space: normal;
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
        .signature {
            height: 60px;
            text-align: center;
            vertical-align: bottom;
        }
        .signature::before {
            content: "";
            display: block;
            margin-bottom: 5px;
        }
         .logo {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 120px;
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
        @media print {
            .fixed-footer {
                position: fixed;
                bottom: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <img src="{{ public_path('images/logo 2 tintas.png') }}" class="logo">

    <h2 class="center">Solicitud de Requisición de Compra No. {{$requisition->id}}</h2>

    <table class="no-border">
        <tr>
            <td><strong>Fecha de creación de solicitud:</strong></td>
            <td>{{ date("d/m/Y",strtotime($requisition->request_date)) }}</td>
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
            <td><strong>Puesto:</strong></td>
            <td>{{ $requisition->user->jobPosition->name ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>Forma de Pago:</strong></td>
            <td>{{ $requisition->paymentType->name ?? '' }}</td>
        </tr>
    </table>

    <table>
        <tr class="section-title">
            <th>Producto</th>
            <th>Proveedor</th>
            <th>Razón</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
            <th>IVA</th>
            <th>Total</th>
        </tr>

        @forelse($requisition->requisitionRows as $row)
        <tr>
            <td>{{ $row->product }}</td>
            <td>{{ $row->supplier->name }}</td>
            <td class="col-reason">{{ $row->reason }}</td>
            <td>{{ $row->product_quantity }}</td>
            <td>${{ number_format($row->product_cost, 2). " " .$row->currencyType->name}}</td>
            <td>${{ number_format($row->product_cost * $row->product_quantity, 2) }}</td>
            <td>{{ $row->has_iva == false ? '$'.number_format(($row->product_cost * $row->product_quantity) * 0.16, 2) . " " .$row->currencyType->name : "NA" }}</td>
            <td>${{ number_format($row->total_cost, 2) . " " .$row->currencyType->name }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align: center;">(Sin productos)</td>
        </tr>
        @endforelse

        <tr>
            <td colspan="5" style="text-align: right;"><strong>TOTAL</strong></td>
            <td>${{ number_format($requisition->totalRows()['subtotal'], 2) }}</td>
            <td>${{ number_format($requisition->totalRows()['totalIva'], 2) }}</td>
            <td>${{ number_format($requisition->totalRows()['total'], 2) }}</td>
        </tr>
    </table>

    <h3>Especificaciones de la Requisición</h3>
    <p style="border: 1px solid #000; height: 80px;">{{ $requisition->notes ?? '' }}</p>
            
    <table style="table-layout: fixed; margin-top: 30px; margin-bottom: 30px;">
        <tr>
            <td class="signature-box">
                @if ($requisition->path_chief_signature)
                    <img src="{{ public_path('storage/'. $requisition->path_chief_signature) }}" alt="Firma de Dirección General" class="signature-img">
                @endif
            </td>
            <td class="signature-box">
                @if ($requisition->path_admin_signature)
                    <img src="{{ public_path('storage/'. $requisition->path_hr_signature) }}" alt="Firma de Administración" class="signature-img">                
                @endif
            </td>
            <td class="signature-box">
                @if ($requisition->path_boss_signature)
                    <img src="{{ public_path('storage/'. $requisition->path_boss_signature) }}" alt="Firma de Jefe Inmediato" class="signature-img">
                @endif
            </td>
            <td class="signature-box">
                @if ($requisition->path_user_signature)
                    <img src="{{ public_path('storage/'. $requisition->path_user_signature) }}" alt="Firma de Solicitante" class="signature-img">
                @endif
            </td>
        </tr>
        <tr class="no-boder">
            <td class="center">
                {{ $requisition->approvalChief->name ?? '' }}
                <br>
                <strong>Firma de Dirección General</strong>
            </td>
            <td class="center">
                {{ $requisition->approvalAdmin->name ?? '' }}
                <br>
                <strong>Firma de Administrador</strong>
            </td>
            <td class="center">
                {{ $requisition->approvalBoss->name ?? 'Sin jefe asignado' }}
                <br>
                <strong>Firma de Jefe Inmediato</strong>
            </td>
            <td class="center">
                {{ $requisition->user->name ?? '' }}
                <br>
                <strong>Firma de Solicitante</strong>
            </td>
        </tr>
    </table>

    <hr>
    <h3>Evidencia</h3>
    
    <div>
        @foreach($requisition->requisitionRows as $row)
            @if($row->evidence)
                <div style="text-align:center; margin-top:20px;">
                    <h3>Imagen del producto: {{ $row->product }}</h3>

                    
                    <img src="file://{{ storage_path('app/public/requisitions/'.$row->evidence) }}" 
                    style="max-width:600px; max-height:800px;">
                </div>
                @endif
                @endforeach
    </div>

    <hr>
</body>
</html>
