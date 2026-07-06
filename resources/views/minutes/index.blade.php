<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="minutes">
    <x-slot:pageTitle>
        Minutas
    </x-slot>

    <x-slot:headerFiles>
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Minutas</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('minutes.reports.monthly') }}" class="btn btn-outline-primary">Reporte mensual</a>
                        @if($allowAdd)
                        <a href="{{route('minutes.create')}}" class="btn btn-success text-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            Agregar
                        </a>
                        @endif
                    </div>
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
    </x-slot>
</x-base-layout>
