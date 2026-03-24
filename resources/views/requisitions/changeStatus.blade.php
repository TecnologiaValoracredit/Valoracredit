<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Cambiar estatus de Requisición
    </x-slot>

    <input type="hidden" id="requisition_id" value="{{$requisition->id}}">

    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Cambiar estatus de Requisición</h5>

                @include('requisitions.showable.fields')

                <div class="row mb-2">
                    <form id="form" class="needs-validation" enctype="multipart/form-data" novalidate method="POST">
                        @csrf
                        @method("PUT")
                        <div class="col-md-12 mb-4">
                            @include("components.custom.forms.textarea", [
                                "id" => 'notes',
                                "name" => 'notes',
                                "type" => "textarea",
                                "placeholder" => "Observaciones...",
                                "label" => "Observaciones",
                                "required" => true,
                                "value" => old('notes'),
                                "invalid_feedback" => "El campo es requerido"
                            ])                                
                        </div>             
                        @if ($currentOwnerPermission == "requisitions.accounting")
                            <div class="row mb-4 d-flex justify-content-center align-items-center">
                                <div class="col-md-6">
                                    @include("components.custom.forms.input", [
                                        "id" => "poliza_number",
                                        "name" => "poliza_number",
                                        "type" => "text",
                                        "placeholder" => "Numero de Póliza...",
                                        "label" => "Numero de Póliza",
                                        "required" => true,
                                        "value" =>  old("poliza_number"),
                                        "invalid_feedback" => "El campo es requerido",
                                    ])
                                </div>
                                <div class="col-md-6">
                                    <label for="evidence" class="form-label">Carga de poliza</label>
                                    <b class="text-danger">*</b>
                                    <input 
                                        name="evidence[]" 
                                        type="file" 
                                        class="form-control"
                                        id="evidence" 
                                        placeholder="Archivo..."
                                        accept="image/*,.pdf" 
                                        required 
                                        multiple>
                                </div>
                            </div>
                        @endif
                    </form>
                    <div class="col-md-12 d-flex justify-content-center gap-4">
                        @switch($currentOwnerPermission)
                            @case("requisitions.boss")
                                @if ($isBossAndCreator)
                                    <button id="approve_requisition_btn" class="btn btn-primary w-15" type="submit"
                                        form="form" formaction="{{ route('requisitions.send', $requisition->id) }}">
                                        Enviar a Tesoreria
                                    </button>
                                    <button id="cancel_requisition_btn" class="btn btn-danger w-15" type="submit"
                                    form="form" formaction="{{ route('requisitions.cancel', $requisition->id) }}">
                                        Cancelar
                                    </button>                      
                                @else
                                    <button id="approve_requisition_btn" class="btn btn-primary w-15" type="submit"
                                        form="form" formaction="{{ route('requisitions.send', $requisition->id) }}">
                                        Enviar a Tesoreria
                                    </button>
                                    <button id="return_requisition_btn" class="btn btn-info w-15" type="submit"
                                    form="form" formaction="{{ route('requisitions.return', $requisition->id) }}">
                                        Devolver
                                    </button>
                                    <button id="deny_requisition_btn" class="btn btn-warning w-15" type="submit"
                                    form="form" formaction="{{ route('requisitions.deny', $requisition->id) }}">
                                        Rechazar
                                    </button>
                                    <button id="cancel_requisition_btn" class="btn btn-danger w-15" type="submit"
                                    form="form" formaction="{{ route('requisitions.cancel', $requisition->id) }}">
                                        Cancelar
                                    </button>                      
                                @endif
                                @break
                            @case("requisitions.treasury")
                                <button id="approve_requisition_btn" class="btn btn-primary w-15" type="submit"
                                    form="form" formaction="{{ route('requisitions.send', $requisition->id) }}">
                                    Enviar a Contabilidad
                                </button>
                                <button id="return_requisition_btn" class="btn btn-danger w-15" type="submit"
                                form="form" formaction="{{ route('requisitions.return', $requisition->id) }}">
                                    Devolver a Jefe Inmediato
                                </button>
                                @break
                            @case("requisitions.accounting")
                                <button id="approve_requisition_btn" class="btn btn-primary w-15" type="submit"
                                    form="form" formaction="{{ route('requisitions.chargePolicy', $requisition->id) }}">
                                    Cargar póliza y enviar a Tesoreria
                                </button>
                                <button id="return_requisition_btn" class="btn btn-danger w-15" type="submit"
                                form="form" formaction="{{ route('requisitions.return', $requisition->id) }}">
                                    Devolver
                                </button>
                                @break
                            @default                        
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reg-modal" aria-labelledby="modal-title" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                @include('requisition_rows.modal_show')
            </div>
        </div>
    </div>

    <x-slot:footerFiles>    
    </x-slot>

</x-base-layout>
