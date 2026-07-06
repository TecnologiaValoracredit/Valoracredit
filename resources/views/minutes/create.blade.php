<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>
        Agregar minuta
    </x-slot>

    <x-slot:headerFiles></x-slot>

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Crear minuta</h5>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('minutes.store') }}">
                    @csrf
                    <div class="col-12">
                        @include("minutes.fields")
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{route('minutes.index')}}" class="btn btn-dark">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot:footerFiles>
        @vite(['resources/js/minutes/fields.js'])
    </x-slot>
</x-base-layout>
