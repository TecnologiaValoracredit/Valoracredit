<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="users">

    <x-slot:pageTitle>
        Informacion de Usuario
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
                    <h5 class="card-title">Detalles de Usuario</h5>
                </div>

                <div class="row mb-2">
                    <div class="row mb-2">
                        <div class="col-4">
                            <div class="mb-2 mt-2">
                                DATOS DE USUARIO
                            </div>

                            <hr>

                            <div>
                                <label for="user_employee_number"><strong>Numero de empleado: </strong></label>
                                <span id="user_employee_number">{{ $user->employee_number ?? "No asignado" }}</span>
                            </div>

                            <div>
                                <label for="user_name"><strong>Nombre: </strong></label>
                                <span id="user_name">{{ $user->name ?? "Nombre no definido" }}</span>
                            </div>

                            <div>
                                <label for="user_email"><strong>Email: </strong></label>
                                <span id="user_email">{{ $user->email ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_phone"><strong>Telefono: </strong></label>
                                <span id="user_phone">{{ $user->phone ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_emergency_phone"><strong>Telefono de emergencia: </strong></label>
                                <span id="user_emergency_phone">{{ $user->emergency_phone ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_role"><strong>Rol: </strong></label>
                                <span id="user_role">{{ $user->role->name ?? "No asignado" }}</span>
                            </div>
                        </div>

                        <div class="col-4">
                            <!-- DATOS LEGALES -->

                            <div class="mb-2 mt-2">
                                DATOS LEGALES
                            </div>

                            <hr>

                            <div>
                                <label for="user_curp"><strong>CURP: </strong></label>
                                <span id="user_curp">{{ $user->curp ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_rfc"><strong>RFC: </strong></label>
                                <span id="user_rfc">{{ $user->rfc ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_nss"><strong>NSS: </strong></label>
                                <span id="user_nss">{{ $user->nss ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_gender"><strong>Genero: </strong></label>
                                <span id="user_gender">{{ $user->genre->name ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_civil_status"><strong>Estado civil: </strong></label>
                                <span id="user_civil_status">{{ $user->civil_status ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_birthday"><strong>Fecha de nacimiento: </strong></label>
                                <span id="user_birthday">{{ $user->birthplace ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_birthplace"><strong>Lugar de nacimiento: </strong></label>
                                <span id="user_birthplace">{{ $user->birthplace ?? "No definido" }}</span>
                            </div>

                        </div>
                        
                        <div class="col-4">
                            <!-- DATOS LABORALES -->

                            <div class="mb-2 mt-2">
                                DATOS LABORALES
                            </div>

                            <hr>

                            <div>
                                <label for="user_branch"><strong>Sucursal: </strong></label>
                                <span id="user_branch">{{ $user->branch->name ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_entry_date"><strong>Fecha de entrada: </strong></label>
                                <span id="user_entry_date">{{ $user->entry_date ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_departament"><strong>Departamento: </strong></label>
                                <span id="user_departament">{{ $user->departament->name ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_job_position"><strong>Puesto de trabajo: </strong></label>
                                <span id="user_job_position">{{ $user->job_position->name ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_boss"><strong>Jefe directo: </strong></label>
                                <span id="user_boss">{{ $user->boss->name ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_salary"><strong>Salario mensual: </strong></label>
                                <span id="user_salary">{{ "$". $user->salary ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_other_benefits"><strong>Otras prestaciones: </strong></label>
                                <span id="user_other_benefits">{{ $user->user_other_benefits ?? "No definido" }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-4">
                            <div class="mb-2 mt-2">
                                DOCUMENTOS ANEXADOS
                            </div>
                            
                            <hr>

                            <div>
                                <label for="user_ine_file"><strong>INE: </strong></label>
                                <span id="user_ine_file">
                                    @if ($user->path_ine)
                                        <a href="{{ asset('storage/' . $user->path_ine) }}" target="_blank"
                                        class="link-primary">Ver imagen</a>
                                    @else
                                    No anexado
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label for="user_curp_file"><strong>CURP: </strong></label>
                                <span id="user_curp_file">
                                    @if ($user->path_curp)
                                        <a href="{{ asset('storage/' . $user->path_curp) }}" target="_blank"
                                        class="link-primary">Ver imagen</a>
                                    @else
                                    No anexado
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label for="user_rfc_file"><strong>RFC: </strong></label>
                                <span id="user_rfc_file">
                                    @if ($user->path_rfc)
                                        <a href="{{ asset('storage/' . $user->path_rfc) }}" target="_blank"
                                        class="link-primary">Ver imagen</a>
                                    @else
                                    No anexado
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label for="user_nss_file"><strong>Numero de seguro social: </strong></label>
                                <span id="user_nss_file">
                                    @if ($user->path_nss)
                                        <a href="{{ asset('storage/' . $user->path_nss) }}" target="_blank"
                                        class="link-primary">Ver imagen</a>
                                    @else
                                    No anexado
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label for="user_address_file"><strong>Comprobante de domicilio: </strong></label>
                                <span id="user_address_file">
                                    @if ($user->path_address)
                                        <a href="{{ asset('storage/' . $user->path_address) }}" target="_blank"
                                        class="link-primary">Ver imagen</a>
                                    @else
                                    No anexado
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label for="user_birth_document_file"><strong>Acta de nacimiento: </strong></label>
                                <span id="user_birth_document_file">
                                    @if ($user->path_birth_document)
                                        <a href="{{ asset('storage/' . $user->path_birth_document) }}" target="_blank"
                                        class="link-primary">Ver imagen</a>
                                    @else
                                    No anexado
                                    @endif
                                </span>
                            </div>

                            <div>
                                <label for="user_account_status_file"><strong>Estado de cuenta: </strong></label>
                                <span id="user_account_status_file">
                                    @if ($user->path_account_status)
                                        <a href="{{ asset('storage/' . $user->path_account_status) }}" target="_blank"
                                        class="link-primary">Ver imagen</a>
                                    @else
                                    No anexado
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="col-4">
                            <!-- DATOS DOMICILIARIOS -->

                            <div class="mb-2 mt-2">
                                DATOS DOMICILIARIOS
                            </div>

                            <hr>

                            <div>
                                <label for="user_residential_address"><strong>Domicilio: </strong></label>
                                <span id="user_residential_address">{{ $user->residential_address ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_colony"><strong>Colonia: </strong></label>
                                <span id="user_colony">{{ $user->colony ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_municipality"><strong>Municipio: </strong></label>
                                <span id="user_municipality">{{ $user->municipality ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_postal_code"><strong>Codigo postal: </strong></label>
                                <span id="user_postal_code">{{ $user->postal_code ?? "No definido" }}</span>
                            </div>

                        </div>

                        <div class="col-4">

                            <div class="mb-2 mt-2">
                                DATOS BANCARIOS
                            </div>

                            <hr>
                            
                            <div>
                                <label for="user_bank"><strong>Banco: </strong></label>
                                <span id="user_bank">{{ $user->bank->name ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_bank_account"><strong>Cuenta bancaria: </strong></label>
                                <span id="user_bank_account">{{ $user->bank_account ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_interbank_code"><strong>Clabe interbancaria: </strong></label>
                                <span id="user_interbank_code">{{ $user->interbank_code ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_plastic_number"><strong>Numero de plastico: </strong></label>
                                <span id="user_plastic_number">{{ $user->plastic_number ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_infonavit_credit_number"><strong>Numero de crédito Infonavit: </strong></label>
                                <span id="user_infonavit_credit_number">{{ $user->infonavit_credit_number ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_discount_factor"><strong>Factor descuento: </strong></label>
                                <span id="user_discount_factor">{{ $user->discount_factor ?? "No definido" }}</span>
                            </div>

                            <div>
                                <label for="user_fonacot_credit_number"><strong>Numero de crédito Fonacot: </strong></label>
                                <span id="user_fonacot_credit_number">{{ $user->fonacot_credit_number ?? "No definido" }}</span>
                            </div>

                            <div>
                            <label for="user_food_pension"><strong>Pensión alimenticia: </strong></label>
                                <span id="user_food_pension">{{ $user->food_pension ?? "No definido" }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="mb-2 mt-2">
                        ACTIVOS DE USUARIO
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


            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>