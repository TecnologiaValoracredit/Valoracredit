<div class="row mb-2">
    <div class="mb-2 mt-2">
        MIS PERMISOS
    </div>
    
    <table class="table">
        <thead>
            <th scope="col">Tipo de activo</th>
            <th scope="col">Marca</th>
            <th scope="col">Color</th>
            <th scope="col">Fecha de compra</th>
            <th scope="col">Número de Serie Generado</th>
            <th scope="col">Imagen del activo</th>
            <th scope="col">Origen</th>
        </thead>

        <tbody>
            @foreach ($user->h_hardwares as $hardware )
                <tr>
                    <td>{{ $hardware->hDeviceType->name }}</td>
                    <td>{{ $hardware->hBrand->name }}</td>
                    <td>{{ $hardware->color ?? "Color no definido" }}</td>
                    <td>{{ $hardware->purchase_date ? date("d/m/Y", strtotime($hardware->purchase_date)) : "Fecha no definida" }}</td>
                    <td>{{ $hardware->serial_number ?? "Numero serial original no definido" }}</td>
                    <td>
                        @if ($hardware->image)
                        <a href="{{ asset('storage/' . $hardware->image) }}" target="_blank"
                            class="link-primary">Ver imagen</a>
                        @else
                        No anexada
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('h_hardwares.show',[$hardware->id]) }}" target="_blank"
                            class="link-primary">Ver más
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
