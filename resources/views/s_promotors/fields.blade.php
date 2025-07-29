<div class="row mb-3">
    <div class="col">
        @include("components.custom.forms.input-select", [
            "id" => "user_id",
            "name" => "user_id",
            "elements" => $users,
            "placeholder" => "Usuario...",
            "value" => isset($s_promotor) ? $s_promotor->user_id :  old("user_id"),
            "label" => "Usuario",
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
                "type" => "number",
                "placeholder" => "Porcentaje de comisión...",
                "label" => "Porcentaje de comisión",
                "required" => true,
                "value" => isset($s_promotor) ? $s_promotor->commission_percentage :  old("commission_percentage"),
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    @endif
    <div class="col">
        @include("components.custom.forms.input-select", [
            "id" => "coordinator_id",
            "name" => "coordinator_id",
            "elements" => $s_coordinators,
            "placeholder" => "Coordinador...",
            "value" => isset($s_promotor) ? $s_promotor->coordinator_id :  old("coordinator_id"),
            "label" => "Coordinador",
            "required" => true,
            "invalid_feedback" => "El campo es requerido"
        ])
    </div>

    <div class="row mt-2">
        <div class="col-6">
            @include("components.custom.forms.input-select", [
                "id" => "s_branch_id",
                "name" => "s_branch_id",
                "elements" => $s_branches,
                "placeholder" => "Descripción...",
                "value" => isset($s_promotor) ? $s_promotor->s_branch_id :  old("s_branch_id"),
                "label" => "Sucursal en CrediSoft",
                "required" => true,
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
        <div class="col-6">
            @include("components.custom.forms.input", [
                "id" => "promotor_credisoft_id",
                "name" => "promotor_credisoft_id",
                "type" => "number",
                "placeholder" => "Id de promotor en CrediSoft...",
                "label" => "Id de promotor en CrediSoft",
                "required" => true,
                "value" => isset($s_promotor) ? $s_promotor->promotor_credisoft_id :  old("promotor_credisoft_id"),
                "invalid_feedback" => "El campo es requerido"
            ])
        </div>
    </div>

    <div class="col my-3">
        @include("components.custom.forms.input-check", [
            "id" => "is_active",
            "name" => "is_active",
            "checked" => isset($role) ? $role->is_active :  true,
            "label" => "Activo",
        ])
    </div>
</div>
