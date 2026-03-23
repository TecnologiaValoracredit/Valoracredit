<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="users">

    <x-slot:pageTitle>
        Cambiar estatus de Permiso
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/accordions.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Detalles de Permiso</h5>
                </div>

                <div class="row mb-3">
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <div class="mb-2 mt-2">
                                DATOS DE SOLICITANTE
                            </div>
                            <hr>
                            <div>
                                <label for="permit_user"><strong>Nombre: </strong></label>
                                <span id="permit_user">{{ $permit->user->name ?? "No asignado" }}</span>
                            </div>
                            <div>
                                <label for="permit_departament"><strong>Departamento: </strong></label>
                                <span id="permit_departament">{{ $permit->departament->name ?? "No asignado" }}</span>
                            </div>
                            <div>
                                <label for="permit_job_position"><strong>Puesto: </strong></label>
                                <span id="permit_job_position">{{ $permit->jobPosition->name ?? "No asignado" }}</span>
                            </div>
                            <div>
                                <label for="permit_boss"><strong>Jefe inmediato: </strong></label>
                                <span id="permit_boss">{{ $permit->boss->name ?? "No asignado" }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2 mt-2">
                                DATOS DE PERMISO
                            </div>
                            <hr>
                            <div>
                                <label for="permit_date"><strong>Fecha de solicitud: </strong></label>
                                <span id="permit_date">{{ $permit->permit_date ? date('d/m/Y', strtotime($permit->permit_date)) : "No asignada" }}</span>
                            </div>
                            <div>
                                <label for="permit_entry_hour"><strong>Hora de entrada: </strong></label>
                                <span id="permit_entry_hour">{{ $permit->entry_hour ? date('d/m/Y H:i', strtotime($permit->entry_hour)) : "No asignada" }}</span>
                            </div>
                            <div>
                                <label for="permit_exit_hour"><strong>Hora de salida: </strong></label>
                                <span id="permit_exit_hour">{{ $permit->exit_hour ? date('d/m/Y H:i', strtotime($permit->exit_hour)) : "No asignada" }}</span>
                            </div>
                            <div>
                                <label for="permit_pending_hours"><strong>Horas pendientes: </strong></label>
                                <span id="permit_pending_hours">{{ $permit->pending_hours ?? "No asignadas" }}</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-2 mt-2">
                                MOTIVO, DESCUENTO Y OBSERVACIONES
                            </div>
                            <hr>
                            <div>
                                <label for="permit_motive"><strong>Motivo: </strong></label>
                                <span id="permit_motive">{{ $permit->motive->name ?? "No asignado" }}</span>
                            </div>
                            <div>
                                <label for="permit_discount_characteristic"><strong>Característica de descuento: </strong></label>
                                <span id="permit_discount_characteristic">{{ $permit->discountCharacteristic->name ?? "No asignado" }}</span>
                            </div>
                            <div>
                                <label for="permit_user_observations"><strong>Observaciones: </strong></label>
                                <span id="permit_user_observations">{{ $permit->user_observations ?? "N/A" }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="mb-2 mt-2">
                            ESTATUS, AUTORIZACION Y OBSERVACIONES
                        </div>
                        <hr>
                        <div class="col-md-4">
                            <label for="permit_status"><strong>Estatus: </strong></label>
                            <span id="permit_status">{{ $permit->permitStatus->name ?? "No asignado" }}</span>
                        </div>
                        <div class="col-md-4">
                            <label for="permit_is_signed_by_hr"><strong>Autorizado por RH: </strong></label>
                            <span id="permit_is_signed_by_hr">{{ is_null($permit->is_signed_by_hr) ? 'Sin respuesta' : ($permit->is_signed_by_hr ? 'Autorizado' : 'No autorizado') }}</span>
                        </div>
                        <div class="col-md-4">
                            <label for="permit_is_signed_by_boss"><strong>Autorizado por Jefe Inmediato: </strong></label>
                            <span id="permit_is_signed_by_boss">{{ is_null($permit->is_signed_by_boss) ? 'Sin respuesta' : ($permit->is_signed_by_boss ? 'Autorizado' : 'No autorizado') }}</span>
                        </div>

                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <label for="permit_hr_observations"><strong>Observaciones de RH: </strong></label>
                            <span id="permit_hr_observations">{{ $permit->hr_observations ?? "Sin observaciones" }}</span>
                        </div>
                        <div class="col-md-4">
                            <label for="permit_boss_observations"><strong>Observaciones de Jefe Inmediato: </strong></label>
                            <span id="permit_boss_observations">{{ $permit->boss_observations ?? "Sin observaciones" }}</span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <form id="permit_form" class="needs-validation" enctype="multipart/form-data" novalidate method="POST" action="{{ route('permits.sign', $permit->id) }}">
                            @csrf
                            @method("PUT")
                            <div class="col-md-12 mb-4">
                                @include("components.custom.forms.textarea", [
                                    "id" => $userObservations,
                                    "name" => $userObservations,
                                    "type" => "textarea",
                                    "placeholder" => "Observaciones...",
                                    "label" => "Observaciones",
                                    "required" => false,
                                    "value" => isset($permit) ? $permit->{$userObservations}  : old($userObservations),
                                    "invalid_feedback" => "El campo es requerido"
                                ])                                
                            </div>

                            @if (!auth()->user()->path_signature)                            
                                <div class="row mb-4 d-flex flex-column align-items-center justify-content-center gap-2">
                                    <div class="col-md-5">
                                        <canvas id="canvas" class="border border-white rounded" style="width:100%;"></canvas>
                                        
                                        <div class="text-center">
                                            <label for="canvas"><strong>Firma</strong></label>
                                        </div>
                                        <input type="hidden" id="signature_data" name="signature_data">
                                    </div>

                                    <div class="col-md-1">
                                        <div id="clear_signature" class="btn btn-danger">Borrar</div>
                                    </div>
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-12 d-flex justify-content-center">            
                                        @include("components.custom.forms.input-check", [
                                            "id" => "save_signature",
                                            "name" => "save_signature",
                                            "checked" => true,
                                            "label" => "Guardar Firma",
                                        ])
                                    </div>
                                </div>
                                
                            @endif

                            <div class="col-md-12 d-flex justify-content-center gap-4">
                                <button type="submit" class="btn btn-primary">Firmar como {{ $userSignature }}</button>
                                <button type="submit" class="btn btn-danger" formaction="{{ route('permits.deny', $permit->id) }}">Rechazar permiso</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite('resources/js/signature.js')
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>