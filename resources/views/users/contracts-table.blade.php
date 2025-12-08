<table class="table">
    <thead>
        <th>Nombre de contrato</th>
        <th>Fecha generado</th>
        <th>Fecha inicio</th>
        <th>Fecha fin</th>
        <th>Archivo generado</th>
        <th>Archivo firmado</th>
        <th>Acciones</th>
    </thead>

    <tbody>
        @if (isset($user))        
            @foreach ($user->contracts as $contract)
                <tr>
                    <td>{{$contract->contract->name}}</td>
                    <td>{{date("d/m/Y H:i", strtotime($contract->created_at))}}</td>
                    <td>{{date("d/m/Y", strtotime($contract->initial_date))}}</td>
                    <td>{{date("d/m/Y", strtotime($contract->final_date))}}</td>

                    <td>
                        <u><a target="_blank" href="{{route('contracts.downloadContract', [$contract->id, 'unsigned'])}}">Descargar</a></u>
                    </td>
                    <td>
                        @if($contract->path_contract_signed != "")
                            <u><a target="_blank" href="{{route('contracts.downloadContract', [$contract->id, 'signed'])}}">Descargar</a></u>
                        @else
                            <input type="file" accept=".pdf" onchange="addUserContractSigned(this, {{$contract->id}})">
                        @endif
                    </td>
                    <td>
                        @if($contract->path_contract_signed == "")
                            <a class="btn btn-danger" onclick="deleteContract('{{$contract->id}}')">Eliminar</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>