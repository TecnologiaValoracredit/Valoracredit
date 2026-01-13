<div class="row mb-2">
    <div class="mb-2 mt-2">MIS CONTRATOS</div>

    <table class="table">
        <thead>
            <th>Nombre de contrato</th>
            <th>Fecha generado</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Archivo generado</th>
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
                            <a target="_blank" class="link-primary" href="{{route('contracts.downloadContract', [$contract->id, 'unsigned'])}}">Descargar</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>