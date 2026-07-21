<div class="row mb-2">
    <div class="mb-2 mt-2">
        MIS VACACIONES
    </div>

    <div class="col-md-6 mb-2"><label><strong>Días restantes de vacaciones: </strong></label> {{ $user->vacationBalance->days_remaining }}</div>
    <div class="col-md-6 mb-3"><label><strong>Días restantes de vacaciones en avance: </strong></label> {{ $user->vacationBalance->advance_days_available }}</div>
    
    <table class="table">
        <thead>
            <th scope="col">Días totales</th>
            <th scope="col">Razón</th>
            <th scope="col">Fecha de solicitud</th>
            <th scope="col">Estatus</th>
            <th scope="col">Origen</th>
        </thead>

        <tbody>
            @foreach ($user->vacations as $vacation )
                <tr>
                    <td>{{ $vacation->total_days }}</td>
                    <td>{{ $vacation->reason }}</td>
                    <td>{{ date("d/m/Y", strtotime($vacation->created_at)) }}</td>
                    <td><span class="badge {{ $vacation->status->badge }}">{{ $vacation->status->name }}</span></td>
                    <td>
                        <a href="{{ route('vacations.show',[$vacation->id]) }}" target="_blank"
                            class="link-primary">Ver más
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
