<div class="table-responsive">
    <table role="table" aria-busy="false" aria-colcount="5" class="table table-hover table-bordered" id="__BVID__415">
        <thead role="rowgroup">
            <tr role="row">
                <th role="columnheader" scope="col" aria-colindex="1"><div></div><b>NO CEDIDOS</b></th>
                <th role="columnheader" scope="col" aria-colindex="2"><div>FIRMA AUTOGRAFA</div></th>
                <th role="columnheader" scope="col" aria-colindex="3"><div>FIRMA DIGITAL</div></th>
                <th role="columnheader" scope="col" aria-colindex="4" class="text-center"><div>TOTAL GENERAL</div></th>
                <th role="columnheader" scope="col" aria-colindex="5" class="text-center"><div>PORCENTAJE</div></th>
            </tr>
        </thead>
        <tbody role="rowgroup">
            <tr>
                <td aria-colindex="1" role="cell">RESGUARDADO</td>
                <td aria-colindex="2" role="cell">{{$no_cedidos_res["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$no_cedidos_res["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$no_cedidos_res["tot"]}}</td>
                <td aria-colindex="4" role="cell">{{$no_cedidos_res["per"]}}%</td>

            </tr>
            <tr>
                <td aria-colindex="1" role="cell">NO APLICA</td>
                <td aria-colindex="2" role="cell">{{$no_cedidos_na["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$no_cedidos_na["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$no_cedidos_na["tot"]}}</td>
                <td aria-colindex="4" role="cell">{{$no_cedidos_na["per"]}}%</td>
            </tr>
            <tr>
                <td aria-colindex="1" role="cell">PENDIENTE</td>
                <td aria-colindex="2" role="cell">{{$no_cedidos_pen["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$no_cedidos_pen["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$no_cedidos_pen["tot"]}}</td>
                <td aria-colindex="4" role="cell">{{$no_cedidos_pen["per"]}}%</td>
            </tr>
            <tr>
                <td aria-colindex="1" role="cell">TOTAL GENERAL</td>
                <td aria-colindex="2" role="cell">{{$no_cedidos_res["aut"] + $no_cedidos_na["aut"] + $no_cedidos_pen["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$no_cedidos_res["dig"] + $no_cedidos_na["dig"] + $no_cedidos_pen["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$no_cedidos_res["tot"] + $no_cedidos_na["tot"] + $no_cedidos_pen["tot"]}}</td>
                <td aria-colindex="5" role="cell">100%</td>

            </tr>
        </tbody>
    </table>
</div>