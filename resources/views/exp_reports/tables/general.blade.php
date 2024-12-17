<div class="table-responsive">
    <table role="table" aria-busy="false" aria-colcount="5" class="table table-hover table-bordered" id="__BVID__415">
        <thead role="rowgroup">
            <tr role="row">
                <th role="columnheader" scope="col" aria-colindex="1"><div></div><b>RESUMEN GENERAL</b></th>
                <th role="columnheader" scope="col" aria-colindex="2"><div>FIRMA AUTOGRAFA</div></th>
                <th role="columnheader" scope="col" aria-colindex="3"><div>FIRMA DIGITAL</div></th>
                <th role="columnheader" scope="col" aria-colindex="4" class="text-center"><div>TOTAL GENERAL</div></th>
                <th role="columnheader" scope="col" aria-colindex="5" class="text-center"><div>PORCENTAJE</div></th>
            </tr>
        </thead>
        <tbody role="rowgroup">
            <tr>
                <td aria-colindex="1" role="cell">FIMUBAC</td>
                <td aria-colindex="2" role="cell">{{$general_fimubac["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$general_fimubac["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$general_fimubac["tot"]}}</td>
                <td aria-colindex="4" role="cell">{{$general_fimubac["per"]}}%</td>

            </tr>
            <tr>
                <td aria-colindex="1" role="cell">VALORA</td>
                <td aria-colindex="2" role="cell">{{$general_valora["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$general_valora["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$general_valora["tot"]}}</td>
                <td aria-colindex="4" role="cell">{{$general_valora["per"]}}%</td>
            </tr>
            <tr>
                <td aria-colindex="1" role="cell">SIN EXPEDIENTE REEST COBRANZA</td>
                <td aria-colindex="2" role="cell">{{$general_reest["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$general_reest["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$general_reest["tot"]}}</td>
                <td aria-colindex="4" role="cell">{{$general_reest["per"]}}%</td>
            </tr>
            <tr>
                <td aria-colindex="1" role="cell">TOTAL GENERAL</td>
                <td aria-colindex="2" role="cell">{{$general_fimubac["aut"] + $general_valora["aut"] + $general_reest["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$general_fimubac["dig"] + $general_valora["dig"] + $general_reest["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$general_fimubac["tot"] + $general_valora["tot"] + $general_reest["tot"]}}</td>
                <td aria-colindex="5" role="cell">100%</td>

            </tr>
        </tbody>
    </table>
</div>