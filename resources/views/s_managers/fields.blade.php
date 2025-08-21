<div class="row mb-2">
    <div class="col">
        @include("components.custom.forms.input-select", [
            "id" => "user_id",
            "name" => "user_id",
            "elements" => $users,
            "placeholder" => "Usuario...",
            "value" => isset($s_coordinator) ? $s_coordinator->user_id :  old("user_id"),
            "label" => "Usuario",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
    <div class="col">
        @include("components.custom.forms.input-select", [
            "id" => "s_branch_id",
            "name" => "s_branch_id",
            "elements" => $s_branches,
            "placeholder" => "Descripción...",
            "value" => isset($s_coordinator) ? $s_coordinator->s_branch_id :  old("s_branch_id"),
            "label" => "Sucursal en CrediSoft",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>
</div>


<div class="row mb-3">
    @if(auth()->user()->hasPermissions("commissions.editCommissionPercentages"))
        <div class="col">
            @include("components.custom.forms.input", [
                "id" => "commission_percentage",
                "name" => "commission_percentage",
                "type" => "numeric",
                "placeholder" => "Porcentaje de comisión...",
                "label" => "Porcentaje de comisión",
                "required" => true,
                "value" => isset($s_coordinator) ? $s_coordinator->commission_percentage :  old("commission_percentage"),
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    @endif
    <div class="col my-2">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => isset($s_coordinator) ? $s_coordinator->is_active :  true,
            "label" => "Activo",
        ])
    </div>
</div>
