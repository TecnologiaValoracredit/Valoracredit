<div class="card suppliers-card flex-shrink-0 mb-10 rounded-2">
    <div class="d-flex justify-content-center p-3 bg-gradient bg-primary">
        <div class="fw-bolder">
            Proveedores
        </div>
    </div>
    <div class=" d-flex flex-column justify-content-between h-100">
        <div class="p-3">
            <div class="d-flex flex-column overflow-y-auto">
                @foreach ($suppliersWithTotals as $supplier => $total)
                    <div class="d-flex justify-content-between p-3">
                        <div class="fw-bolder">
                            Nombre
                        </div>
                        <div>
                            {{ $supplier }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-between p-3">
                        <div class="fw-bolder">
                            Importe
                        </div>
                        <div>
                            &dollar;{{ number_format($total, 2) }}
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    
        <div class="d-flex justify-content-between p-3">
            <div class="fw-bolder">
                Total
            </div>
            <div>
                &dollar;{{ number_format($requisition_global->totalGlobalAmount(), 2 ) }}
            </div>
        </div>
    </div>
</div>