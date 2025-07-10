<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="roles">
    <x-slot:pageTitle>
        Roles 
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">

        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Permisos de {{$role->name}}</h5>
                <hr>
                <p>Módulos</p>
                <div class="simple-pill">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @foreach($modules as $key => $module)
                            @if($module->parent_id == null || $module->hasSubmodules())
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{$key == 0 ? 'active' : ''}}" id="pills-{{$module->name}}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{$module->name}}" type="button" role="tab" aria-controls="pills-{{$module->name}}" aria-selected="true">{{$module->description}}</button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <form class="row g-3" method="POST" action="{{ route('roles.savePermissions', $role->id) }}">
                        @csrf
                        @method("PUT")
                        <div class="tab-content" id="pills-tabContent">
                            @foreach($modules as $key => $module)
                                @if($module->hasSubmodules())
                                    <div class="tab-pane fade show {{$key == 0 ? 'active' : ''}}" id="pills-{{$module->name}}" role="tabpanel" aria-labelledby="pills-{{$module->name}}-tab" tabindex="0">
                                        <div class="vertical-pill">
                                            <div class="d-flex align-items-start">
                                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab2" role="tablist" aria-orientation="vertical">
                                                    @foreach($module->submodules as $key2 => $submodule)
                                                        <button class="nav-link {{$key2 == 0 ? 'active' : ''}}" id="v-pills-{{$submodule->name}}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{$submodule->name}}" type="button" role="tab" aria-controls="v-pills-{{$submodule->name}}" aria-selected="true">{{$submodule->description}}</button>
                                                    @endforeach
                                                </div>
                                                <div class="tab-content" id="v-pills-tabContent">
                                                    @foreach($module->submodules as $key2 => $submodule)
                                                        <div class="tab-pane fade show {{$key2 == 0 ? 'active' : ''}}" id="v-pills-{{$submodule->name}}" role="tabpanel" aria-labelledby="v-pills-{{$submodule->name}}-tab" tabindex="0">
                                                            <p>Funciones</p>
                                                            @foreach($submodule->permissions as $permission)
                                                                <div class="form-check form-check-primary d-block form-check-inline">
                                                                    <input name="permission[{{$permission->id}}]" class="form-check-input" type="checkbox" id="form-check-primary-{{$permission->id}}" {{$role->hasPermission($permission->id) ? "checked" : ""}}>
                                                                    <label class="form-check-label" for="form-check-primary-{{$permission->id}}">
                                                                        {{$permission->permissionFunction->name}} - {{$permission->permissionFunction->description}}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @if($module->parent_id == null)

                                        <div class="tab-pane fade show {{$key == 0 ? 'active' : ''}}" id="pills-{{$module->name}}" role="tabpanel" aria-labelledby="pills-{{$module->name}}-tab" tabindex="0">
                                            <p>Funciones</p>
                                            @foreach($module->permissions as $permission)
                                                <div class="form-check form-check-primary d-block form-check-inline">
                                                    <input name="permission[{{$permission->id}}]" class="form-check-input" type="checkbox" id="form-check-primary-{{$permission->id}}" {{$role->hasPermission($permission->id) ? "checked" : ""}}>
                                                    <label class="form-check-label" for="form-check-primary-{{$permission->id}}">
                                                        {{$permission->permissionFunction->name}} - {{$permission->permissionFunction->description}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{route('roles.index')}}" class="btn btn-dark">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>