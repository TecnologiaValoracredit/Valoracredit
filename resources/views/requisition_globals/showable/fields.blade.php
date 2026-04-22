<div class="row mb-4 mt-2">
    <div class="col-md-4 d-flex align-items-end">
        <div>
            <label for="user"><strong>Solicita: </strong></label>
            <span id="user">{{ $requisition_global->creator->name ?? "No asignado" }}</span>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div>
            <label for="request_date"><strong>Fecha de solicitud: </strong></label>
            <span id="request_date">{{ date("d/m/Y", strtotime( $requisition_global->created_at)) ?? "No asignado" }}</span>
        </div>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div>
            <label for="application_date"><strong>Fecha de aplicación: </strong></label>
            <span id="application_date">{{ date("d/m/Y", strtotime( $requisition_global->application_date)) ?? "No asignado" }}</span>
        </div>
    </div>
</div>

<ul class="nav nav-tabs mb-2" id="navbar" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="suppliers-tab" data-bs-toggle="tab" data-bs-target="#suppliers-pane" type="button" role="tab">
            Proveedores
        </button>
    </li>
    @foreach ($requisition_global->expenseTypes() as $key => $value)
    <li class="nav-item" role="presentation">
        <button class="nav-link" id={{ Str::slug($value) . "-tab" }} data-bs-toggle="tab" data-bs-target={{"#". Str::slug($value) ."-pane"}} type="button" role="tab">
            {{$value}}
        </button>
    </li>
    @endforeach
</ul>

<div class="tab-content mb-2 mt-2">
    <div class="tab-pane show active" id="suppliers-pane" role="tabpanel" aria-labelledby="suppliers-tab">
        <div class="d-flex justify-content-center">   
            @include('requisition_globals.showable.suppliers_card')
        </div>
    </div>
    @foreach ($requisition_global->expenseTypes() as $key => $value)
        <div class="tab-pane fade" id={{ Str::slug($value) . "-pane" }} role="tabpanel" aria-labelledby={{ Str::slug($value) . "-tab" }}>
            <div>
                @include('requisition_globals.showable.requisition_cards', [
                    "requisitions" => $requisition_global->getRequisitionsByExpenseType($key),
                    "total" => $requisition_global->getExpenseTypeTotal($key),
                ])
            </div>
        </div>
    @endforeach
</div>