<div class="row mb-2">
    <div class="mb-2 mt-2">
        MIS PERMISOS
    </div>
    
    <table class="table">
        <thead>
            <th scope="col">Folio</th>
            <th scope="col">Motivo</th>
            <th scope="col">Estatus</th>
            <th scope="col">Fecha de solicitud</th>
            <th scope="col">Origen</th>
        </thead>

        <tbody>
            @foreach ($user->permits as $permit )
                <tr>
                    <td>{{ $permit->id }}</td>
                    <td>{{ $permit->motive->name }}</td>
                    <td><span class="badge {{ $permit->permitStatus->color }}">{{ $permit->permitStatus->name }}</span></td>
                    <td>{{ date("d/m/Y", strtotime($permit->permit_date)) }}</td>
                    <td>
                        <a href="{{ route('permits.show',[$permit->id]) }}" target="_blank"
                            class="link-primary">Ver más
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
