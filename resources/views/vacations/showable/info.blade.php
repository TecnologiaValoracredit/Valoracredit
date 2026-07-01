<div class="row mb-3">
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="mb-2 mt-2">
                DATOS DE SOLICITANTE
            </div>
            <hr>
            <div>
                <label for="user"><strong>Nombre: </strong></label>
                <span id="user">{{ $vacation->user->name ?? "No asignado" }}</span>
            </div>
            <div>
                <label for="boss"><strong>Jefe Inmediato: </strong></label>
                <span id="boss">{{ $vacation->user->name ?? "No asignado" }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-2 mt-2">
                DATOS DE VACACIONES
            </div>
            <hr>
            <div>
                <label for="total_days"><strong>Días totales: </strong></label>
                <span id="total_days">{{ $vacation->total_days }}</span>
            </div>
            <div>
                <label for="reason"><strong>Razón: </strong></label>
                <span id="reason">{{ $vacation->reason }}</span>
            </div>
            <div>
                <label for="notes"><strong>Notas: </strong></label>
                <span id="notes">{{ $vacation->notes }}</span>
            </div>
            <div>
                <label for="created_at"><strong>Fecha de creación: </strong></label>
                <span id="created_at">{{ date("d-m-Y",strtotime($vacation->created_at)) }}</span>
            </div>
        </div>
    </div>

    <div class="row mb-5 mt-2">
        <div class="col-md-12">
            <div class="mb-2 mt-2 text-center">
                FECHAS SOLICITADAS
            </div>
            <hr>
        </div>
        <div class="col-md-12 d-flex gap-2 flex-wrap justify-content-around text-dark">
            @foreach ($vacation->dates as $key => $date)
            <div class="mt-2 mb-2">{{ date("d-m-Y", strtotime($date->date)) }}</div>
            @endforeach
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-6">
            <div class="mb-2 mt-2">
                DECISIÓN Y NOTAS - RH
            </div>
            <hr>
            <div>
                <label for="user"><strong>Decisión: </strong></label>
                <span id="user">{{ $vacation->hrOrWithPermissionsApproval('vacations.seeAllVacations')->decision ?? "Decisión no tomada" }}</span>
            </div>
            <div>
                <label for="boss"><strong>Notas: </strong></label>
                <span id="boss">{{ $vacation->hrOrWithPermissionsApproval('vacations.seeAllVacations')->notes ?? "Notas no ingresadas" }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-2 mt-2">
                DECISIÓN Y NOTAS - JEFE INMEDIATO
            </div>
            <hr>
            <div>
                <label for="total_days"><strong>Decisión: </strong></label>
                <span id="total_days">{{ $vacation->bossApproval()->decision ?? "Decisión no tomada" }}</span>
            </div>
            <div>
                <label for="reason"><strong>Notas: </strong></label>
                <span id="reason">{{ $vacation->bossApproval()->notes ?? "Notas no ingresadas" }}</span>
            </div>
        </div>
    </div>
</div>