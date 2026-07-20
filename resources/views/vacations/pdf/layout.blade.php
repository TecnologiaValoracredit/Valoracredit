<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Vacaciones {{$vacation->id}} - Aprobada</title>
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
        td.w-50 {
            width: 50%;
        }
        .no-border th,
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
        .text-center {
            text-align: center;
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
        .signature-table {
            position: absolute;
            bottom: 25%;
        }
    </style>
</head>
<body>
    @php
        $formatVacationDate = function ($value) {
            return ucfirst(\Carbon\Carbon::parse($value)->locale('es')->translatedFormat('d/m/Y (l)'));
        };
    @endphp

    @if(optional(auth()->user()->company)->id == 1 || auth()->user()->company == null)
        <img src="{{ public_path('images/logo 2 tintas.png') }}" class="logo">
    @else
        <img src="{{ public_path('images/gcelogo.png') }}" class="logo">
    @endif

    <h2 class="center">Solicitud de Vacaciones No. {{$vacation->id}} - Aprobada</h2>

    <h3 style="margin-top: 50px;">Detalles de solicitante y vacaciones</h3>

    <table class="no-border" style="width: 100%; margin-top: 24px;">
        <tr style="width: 100%">
            <td class="w-50">
                <table>
                    <tr>
                        <td><strong>Nombre del Solicitante:</strong></td>
                        <td>{{ $vacation->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jefe Inmediato:</strong></td>
                        <td>{{ $vacation->boss->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Departamento:</strong></td>
                        <td>{{ $vacation->user->departament->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Puesto:</strong></td>
                        <td>{{ $vacation->user->jobPosition->name ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td class="w-50">
                <table>
                    <tr>
                        <td><strong>Días totales:</strong></td>
                        <td>{{ $vacation->total_days ?? '' }}</td>  
                    </tr>
                    <tr>
                        <td><strong>Razón:</strong></td>
                        <td>{{ $vacation->reason ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Notas:</strong></td>
                        <td>{{ $vacation->notes ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de solicitud:</strong></td>
                        <td>{{ date("d/m/Y",strtotime(($vacation->created_at))) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 80px;">Datos de vacaciones</h3>

    <table>
        <tr class="section-title">
            <th colspan="{{ $vacation->total_days }}" class="text-center">
                Fechas solicitadas (días que faltará el solicitante)
            </th>
        </tr>

        <tr>
            @foreach ($vacation->dates as $key => $date)
            <td class="text-center">{{ $formatVacationDate($date->date) }}</td>
            @endforeach
        </tr>
    </table>

    <table class="no-border" style="width: 100%; margin-top: 100px;">
        <tr>
            <th><strong>Decisión y notas - RH</strong></th>
            <th><strong>Decisión y notas - Jefe Inmediato</strong></th>
        </tr>
        <tr style="width: 100%">
            <td class="w-50">
                <table>
                    <tr>
                        <td><strong>Decisión:</strong></td>
                        <td>{{ $vacation->hrOrWithPermissionsApproval('vacations.seeAllVacations')->decision ?? "Decisión no tomada" }}</td>
                    </tr>
                    <tr>
                        <td><strong>Notas:</strong></td>
                        <td>{{ $vacation->hrOrWithPermissionsApproval('vacations.seeAllVacations')->notes ?? "Notas no ingresadas" }}</td>
                    </tr>
                </table>
            </td>
            <td class="w-50">
                <table>
                    <tr>
                        <td><strong>Decisión:</strong></td>
                        <td>{{ $vacation->bossApproval()->decision ?? "Decisión no tomada" }}</td>
                    </tr>
                    <tr>
                        <td><strong>Notas:</strong></td>
                        <td>{{ $vacation->bossApproval()->notes ?? "Notas no ingresadas" }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="signature-table" style="table-layout: fixed">
        <tr>
            <td class="signature-box">
                @if ($vacation->hrOrWithPermissionsApproval('vacations.seeAllVacations')->user->path_signature)
                    <img src="{{ storage_path("app/public/{$vacation->hrOrWithPermissionsApproval('vacations.seeAllVacations')->user->path_signature}") }}" alt="Firma de RH" class="signature-img">                
            @endif
            </td>
            <td class="signature-box">
                @if ($vacation->boss->path_signature)
                    <img src="{{ storage_path("app/public/{$vacation->boss->path_signature}") }}" alt="Firma de Jefe Inmediato" class="signature-img">
                @endif
            </td>
            <td class="signature-box">
                @if ($vacation->user->path_signature)
                    <img src="{{ storage_path("app/public/{$vacation->user->path_signature}") }}" alt="Firma de Usuario" class="signature-img">
                @endif
            </td>
        </tr>
        <tr class="no-boder">
            <td class="center">
                {{ $vacation->hrOrWithPermissionsApproval('vacations.seeAllVacations')->user->name ?? '' }}
                <br>
                <strong>Firma de RH</strong>
            </td>
            <td class="center">
                {{ $vacation->boss->name ?? 'Sin jefe asignado' }}
                <br>
                <strong>Firma de Jefe Inmediato</strong>
            </td>
            <td class="center">
                {{ $vacation->user->name ?? '' }}
                <br>
                <strong>Firma de Solicitante</strong>
            </td>
        </tr>
    </table>

</body>
</html>
