<div class="row mb-2 overflow-auto">
    <div class="mb-2 mt-2">
        FLUJO DE REQUISICIÓN
    </div>
    
    <table class="table">
        <thead>
            <th>Folio de Global</th>
            <th>Responsable</th>
            <th>Rol</th>
            <th>Decisión</th>
            <th>Notas</th>
            <th>Fecha tomada</th>
        </thead>

        <tbody>
            @foreach ($requisition->approvals as $approval)
                <tr>
                    <td>{{ $approval->requisition_global_id }}</td>
                    <td>{{ $approval->user->name }}</td>
                    <td>{{ $approval->user->role->name }}</td>
                    <td>
                        @switch($approval->decision)
                            @case("Aprobada")
                                <span class="badge badge-success">Aprobado</span>
                                @break
                            @case("Devuelta")
                                <span class="badge badge-danger">Devuelta</span>
                                @break
                            @case("Rechazada")
                                <span class="badge badge-danger">Rechazada</span>
                                @break
                            @default
                                No especificado
                        @endswitch
                    </td>
                    <td>{{ $approval->notes }}</td>
                    <td>{{ date("d/m/Y H:i", strtotime($approval->created_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>