<table class="table min-w-max table-auto border border-gray-300">
    <thead style="background-color: #f3f4f6;">
        <tr>
            <th class="px-4 py-2 border">Coordinador</th>
            @foreach(array_keys($institutions) as $institution)
                <th class="px-4 py-2 border">{{ $institution }}</th>
            @endforeach
            <th class="px-4 py-2 border" style="background-color: #fef9c3;">Total Coordinador</th>
        </tr>
    </thead>
    <tbody>
        @foreach($coordinators as $coord => $sales)
            <tr>
                <td class="px-4 py-2 border">{{ $coord }}</td>
                @php $total_by_coordinator = 0; @endphp
                @foreach(array_keys($institutions) as $institution)
                    @php
                        $value = $sales[$institution];
                        $total_by_coordinator += $value;
                        // Calcular % sobre el total
                        $percent = $grand_total > 0 ? ($value / $grand_total) * 100 : 0;
                        
                        // Determinar estilo por % (y valor 0)
                        if ($value == 0) {
                            $style = 'background-color: #fecaca; color: #991b1b;'; // rojo fuerte
                        } elseif ($percent < 3) {
                            $style = 'background-color: #fef9c3; color: #78350f;'; // amarillo claro
                        } elseif ($percent < 5) {
                            $style = 'background-color: #fde68a; color: #78350f;'; // naranja claro
                        } elseif ($percent < 10) {
                            $style = 'background-color: #fcd34d; color: #78350f;'; // amarillo más fuerte
                        } else {
                            $style = 'background-color: #bbf7d0; color: #065f46;'; // verde claro
                        }
                    @endphp
                    <td class="px-4 py-2 border" style="{{ $style }}">
                        ${{ number_format($value, 2) }}
                    </td>
                @endforeach
                <td class="px-4 py-2 border font-bold" style="background-color: #fef9c3;">
                    ${{ number_format($total_by_coordinator, 2) }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot style="background-color: #f3f4f6; font-weight: bold;">
        <tr>
            <td class="px-4 py-2 border text-right">Total Institución:</td>
            @php $grand_total = 0; @endphp
            @foreach(array_keys($institutions) as $institution)
                @php
                    $sum = $totals_by_institution[$institution] ?? 0;
                    $grand_total += $sum;
                @endphp
                <td class="px-4 py-2 border" style="background-color: #fef9c3;">
                    ${{ number_format($sum, 2) }}
                </td>
            @endforeach
            <td class="px-4 py-2 border" style="background-color: #fde68a;">
                ${{ number_format($grand_total, 2) }}
            </td>
        </tr>
    </tfoot>
</table>