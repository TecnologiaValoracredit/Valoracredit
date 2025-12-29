<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Permiso {{$permit->id}} - Aprobada</title>
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
    </style>
</head>
<body>

    <img src="{{ public_path('images/logo 2 tintas.png') }}" class="logo">

    <h2 class="center">Solicitud de Permiso No. {{$permit->id}} - Aprobada</h2>

    <h3>Especificaciones de solicitante</h3>

    <table class="no-border">
        <tr>
            <td><strong>Fecha:</strong></td>
            <td>{{ date("d-m-Y",strtotime(($permit->permit_date))) }}</td>
        </tr>
        <tr>
            <td><strong>Nombre del Solicitante:</strong></td>
            <td>{{ $permit->user->name ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>Departamento:</strong></td>
            <td>{{ $permit->departament->name ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>Puesto:</strong></td>
            <td>{{ $permit->jobPosition->name ?? '' }}</td>
        </tr>
    </table>

    <h3>Especificaciones de horarios, motivo y característica de descuento</h3>

    <table>
        <tr class="section-title">
            <th>Hora de entrada</th>
            <th>Hora de salida</th>
            <th>Horas pendientes</th>
        </tr>

        <tr>
            <td>{{ $permit->entry_hour ? date('d/m/Y H:i', strtotime($permit->entry_hour)) : '' }}</td>
            <td>{{ $permit->exit_hour ? date('d/m/Y H:i', strtotime($permit->exit_hour)) : '' }}</td>
            <td>{{ $permit->pending_hours ?? '' }}</td>
        </tr>
    </table>

    <br>

    <table class="no-border">
        <tr>
            <td>
                <span><strong>Motivo:</strong></span>
                <span>{{ $permit->motive->name ?? ''}}</span>
            </td>
            <td class="right-text">
                <span><strong>Característica de descuento:</strong></span>
                <span>{{ $permit->discountCharacteristic->name ?? '' }}</span>
            </td>
        </tr>
    </table>

    <br>

    <h3>Observaciones del solicitante</h3>
    <p class="">{{ $permit->user_observations ?? '' }}</p>
    <br>

    <hr>
    <br>

    <h3><strong>Observaciones de Recursos Humanos</strong></h3>
    <p>{{ $permit->hr_observations ?? ''}}</p>
    <br>

    <h3><strong>Observaciones de Jefe Inmediato</strong></h3>
    <p>{{ $permit->boss_observations ?? ''}}</p>
    <br>

    <br>

    <table class="" style="table-layout: fixed">
        <tr>
            <td class="signature-box">
                @if ($permit->path_hr_signature)
                    <img src="{{ public_path('storage/'. $permit->path_hr_signature) }}" alt="Firma de RH" class="signature-img">                
                @endif
            </td>
            <td class="signature-box">
                @if ($permit->path_boss_signature)
                    <img src="{{ public_path('storage/'. $permit->path_boss_signature) }}" alt="Firma de Jefe Inmediato" class="signature-img">
                @endif
            </td>
            <td class="signature-box">
                @if ($permit->path_user_signature)
                    <img src="{{ public_path('storage/'. $permit->path_user_signature) }}" alt="Firma de Usuario" class="signature-img">
                @endif
            </td>
        </tr>
        <tr class="no-boder">
            <td class="center">
                {{ $permit->hr->name ?? '' }}
                <br>
                <strong>Firma de RH</strong>
            </td>
            <td class="center">
                {{ $permit->boss->name ?? 'Sin jefe asignado' }}
                <br>
                <strong>Firma de Jefe Inmediato</strong>
            </td>
            <td class="center">
                {{ $permit->user->name ?? '' }}
                <br>
                <strong>Firma de Solicitante</strong>
            </td>
        </tr>
    </table>

</body>
</html>
