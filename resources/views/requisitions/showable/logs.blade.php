<div class="row mb-2 overflow-auto">
    <div class="mb-2 mt-2">
        FLUJO DE REQUISICIÓN
    </div>
    
    <table class="table">
        <thead>
            <th>Responsable</th>
            <th>Rol</th>
            <th>Acción</th>
            <th>De Estatus</th>
            <th>A Estatus</th>
            <th>Notas</th>
            <th>Fecha de creación</th>
        </thead>

        <tbody>
            @foreach ($requisition->logs as $log)
                <tr>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->user->role->name }}</td>
                    <td>{{ $log->action }}</td>
                    <td><span class="badge {{ $log->fromStatusId->color ?? '' }} text-light">{{ $log->fromStatusId->name ?? "" }}</span></td>
                    <td><span class="badge {{ $log->toStatusId->color ?? '' }} text-light">{{ $log->toStatusId->name ?? "" }}</span></td>
                    <td>{{ $log->notes }}</td>
                    <td>{{ date("d/m/Y H:i", strtotime($log->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>