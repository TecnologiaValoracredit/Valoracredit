<div class="table-responsive">
    <table role="table" aria-busy="false" aria-colcount="5" class="table table-hover table-bordered" id="__BVID__415">
        <thead role="rowgroup">
            <tr role="row">
                <th role="columnheader" scope="col" aria-colindex="1"><div></div><b>CEDIDOS FIMUBAC</b></th>
                <th role="columnheader" scope="col" aria-colindex="2"><div>FIRMA AUTOGRAFA</div></th>
                <th role="columnheader" scope="col" aria-colindex="3"><div>FIRMA DIGITAL</div></th>
                <th role="columnheader" scope="col" aria-colindex="4" class="text-center"><div>TOTAL GENERAL</div></th>
                <th role="columnheader" scope="col" aria-colindex="5" class="text-center"><div>PORCENTAJE</div></th>
            </tr>
        </thead>
        <tbody role="rowgroup">
            <tr>
                <td aria-colindex="1" role="cell">NO APLICA</td>
                <td aria-colindex="2" role="cell">{{$fimubac_na["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$fimubac_na["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$fimubac_na["tot"]}}</td>
                <td aria-colindex="4" role="cell">{{$fimubac_na["per"]}}%</td>

            </tr>
            <tr>
                <td aria-colindex="1" role="cell">SAFE DATA</td>
                <td aria-colindex="2" role="cell">{{$fimubac_safe["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$fimubac_safe["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$fimubac_safe["tot"]}}</td>
                <td aria-colindex="4" role="cell">{{$fimubac_safe["per"]}}%</td>
            </tr>
            <tr>
                <td aria-colindex="1" role="cell">TOTAL GENERAL</td>
                <td aria-colindex="2" role="cell">{{$fimubac_safe["aut"] + $fimubac_na["aut"]}}</td>
                <td aria-colindex="3" role="cell">{{$fimubac_safe["dig"] + $fimubac_na["dig"]}}</td>
                <td aria-colindex="4" role="cell">{{$fimubac_safe["tot"] + $fimubac_na["tot"]}}</td>
                <td aria-colindex="5" role="cell">100%</td>

            </tr>
        </tbody>
    </table>
</div>