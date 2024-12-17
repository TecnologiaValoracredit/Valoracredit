<div class="table-responsive">
    <table role="table" aria-busy="false" aria-colcount="5" class="table table-hover table-bordered" id="__BVID__415">
        <thead role="rowgroup">
            <tr role="row">
                <th role="columnheader" scope="col" aria-colindex="1"><div></div><b>POR DEPENDENCIA</b></th>
                <th role="columnheader" scope="col" aria-colindex="2"><div>RESGUARDADO</div></th>
                <th role="columnheader" scope="col" aria-colindex="3"><div>NO APLICA</div></th>
                <th role="columnheader" scope="col" aria-colindex="4" class="text-center"><div>PENDIENTE</div></th>
                <th role="columnheader" scope="col" aria-colindex="5" class="text-center"><div>TOTALGENERAL</div></th>
                <th role="columnheader" scope="col" aria-colindex="5" class="text-center"><div>PORCENTAJE</div></th>
            </tr>
        </thead>
        <tbody role="rowgroup">
            @foreach($report_by_institution as $institution)
                <tr>
                    <td aria-colindex="1" role="cell">{{$institution->name}}</td>
                    <td aria-colindex="2" role="cell">{{$institution->resguardados}}</td>
                    <td aria-colindex="3" role="cell">{{$institution->no_aplica}}</td>
                    <td aria-colindex="4" role="cell">{{$institution->pendiente}}</td>
                    <td aria-colindex="6" role="cell">{{$institution->total_general}}</td>
                    <td aria-colindex="5" role="cell">{{$institution->porcentaje_pendiente}}%</td>
                </tr>
            @endforeach
            <tr>
                <td aria-colindex="1" role="cell">TOTAL GENERAL</td>
                <td aria-colindex="2" role="cell">{{$report_by_institution->sum("resguardados")}}</td>
                <td aria-colindex="3" role="cell">{{$report_by_institution->sum("no_aplica")}}</td>
                <td aria-colindex="4" role="cell">{{$report_by_institution->sum("pendiente")}}</td>
                <td aria-colindex="6" role="cell">{{$report_by_institution->sum("total_general")}}</td>
                <td aria-colindex="5" role="cell">100%</td>
            </tr>
        </tbody>
    </table>
</div>