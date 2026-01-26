<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Editar requisición
    </x-slot>


    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Editar requisición</h5>
                <form id="requisition_form" class="row g-3 needs-validation" novalidate method="POST" action="{{ route('requisitions.update', $requisition) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("requisitions.fields")

                            <hr>
                            <div class="row my-3 m-0 mb-4">
                                <div class="col">
                                    <h5>Productos</h5>
                                </div>
                                <div class="col">
                                    <div class="text-end">
                                        <!-- Button trigger modal -->
                                        <button id="show_btn" type="button" title="Agregar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reg-modal">
                                            Agregar producto
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="overflow-auto">
                                <table class="table">
                                    <thead>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Incluya IVA</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody id="table_body">
                                        @foreach ($requisition_rows as $row)
                                            <tr data-added="false">
                                                <td>{{ $row->product }}</td>
                                                <td>{{ $row->product_quantity }}</td>
                                                <td>{{ $row->product_cost }}</td>
                                                <td>{{ $row->has_iva ? "Si" : "No" }}</td>
                                                <td>{{ $row->total_cost }}</td>
                                                <td>
                                                    <a onclick="editProduct(this, true)" title="Editar" class="btn btn-outline-secondary btn-icon p-auto">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                                        </svg>
                                                    </a>
                                                    <a onclick="deleteProduct(this)" title="Eliminar" class="btn btn-outline-danger btn-outline-danger btn-icon p-auto">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash">
                                                            <polyline points="3 6 5 6 21 6"/>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                        </svg>
                                                    </a>
                                                </td>
                                                <input type="hidden" name="evidence_length" value="1">
                                                <input type="hidden" name="evidence_1" value="{{ $row->evidence }}">
                                                <input type="hidden" name="has_iva" value="{{ $row->has_iva ? "on" : "off" }}">
                                                <input type="hidden" name="link" value="{{ $row->link ?? '' }}">
                                                <input type="hidden" name="product" value="{{ $row->product }}">
                                                <input type="hidden" name="product_cost" value="{{ $row->product_cost }}">
                                                <input type="hidden" name="product_description" value="{{ $row->product_description }}">
                                                <input type="hidden" name="product_quantity" value="{{ $row->product_quantity }}">
                                                <input type="hidden" name="reason" value="{{ $row->reason }}">
                                                <input type="hidden" name="supplier_id" value="{{ $row->supplier_id }}">
                                                <input type="hidden" name="total_cost" value="{{ $row->total_cost }}">
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if (!auth()->user()->path_signature)
                                @include('components.custom.forms.input-signature')
                            @endif

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('requisitions.index')}}" class="btn btn-dark">Cancelar</a>
                                <button id="submit_btn" type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reg-modal" aria-labelledby="modal-title" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                @include('requisition_rows.modal_add')
            </div>
        </div>
    </div>

    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>