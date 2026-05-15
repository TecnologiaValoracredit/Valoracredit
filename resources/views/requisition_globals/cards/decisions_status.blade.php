<div class="d-flex justify-content-between px-3 py-2">
    <div class="fw-bolder">
        Decisión de D.G.
    </div>
    <div class="d-flex justify-content-center align-items-center">
        @if ($requisition->latestRoleApproval('Dirección general'))
            @switch($requisition->latestRoleApproval('Dirección general')->decision)
                @case("Aprobada")
                    <span class="badge badge-success">Aprobada</span>
                    @break

                @case("Rechazada")
                    <span class="badge badge-danger">Rechazada</span>
                    @break
                @case("Devuelta")
                    <span class="badge badge-danger">Devuelta</span>
                    @break
                @default

            @endswitch
        @elseif($requisition->latestRoleApproval('Admin'))
            @switch($requisition->latestRoleApproval('Admin')->decision)
                @case("Aprobada")
                    <span class="badge badge-success">Aprobada</span>
                    @break

                @case("Rechazada")
                    <span class="badge badge-danger">Rechazada</span>
                    @break
                @case("Devuelta")
                    <span class="badge badge-danger">Devuelta</span>
                    @break
                @default

            @endswitch
        @else
            <div>
                Aun no revisada
            </div>
        @endif
    </div>
</div>
<div class="d-flex justify-content-between px-3 py-2">
    <div class="fw-bolder">
        Decisión de Administración
    </div>
    <div class="d-flex justify-content-center align-items-center">
        @if ($requisition->adminSignatureApproval())
            <span class="badge badge-success">Aprobada</span>
        @elseif ($requisition->latestRoleApproval('Administración'))
            @switch($requisition->latestRoleApproval('Administración')->decision)
                @case("Aprobada")
                    <span class="badge badge-success">Aprobada</span>
                    @break

                @case("Rechazada")
                    <span class="badge badge-danger">Rechazada</span>
                    @break
                @case("Devuelta")
                    <span class="badge badge-danger">Devuelta</span>
                    @break
                @default

            @endswitch
        @else
            <div>
                Aun no revisada
            </div>
        @endif
    </div>
</div>
<div class="d-flex justify-content-between px-3 py-2">
    <div class="fw-bolder">
        Decisión de Contabilidad
    </div>
    <div class="d-flex justify-content-center align-items-center">
        @if($requisition->adminSignatureApproval())
            <span class="badge badge-success">Aprobada</span>
        @elseif ($requisition->latestRoleApproval('Contabilidad'))
            @switch($requisition->latestRoleApproval('Contabilidad')->decision)
                @case("Aprobada")
                    <span class="badge badge-success">Aprobada</span>
                    @break

                @case("Rechazada")
                    <span class="badge badge-danger">Rechazada</span>
                    @break
                @case("Devuelta")
                    <span class="badge badge-danger">Devuelta</span>
                    @break
                @default

            @endswitch
        @else
            <div>
                Aun no revisada
            </div>
        @endif
    </div>
</div>