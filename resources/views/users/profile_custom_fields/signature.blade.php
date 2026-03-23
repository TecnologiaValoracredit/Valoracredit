<div class="row mb-2">
    <div class="mb-2 mt-2">FIRMA</div>

    <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="col-md-9 text-center">
            @if ($user->path_signature)
                    <div class="border">
                        <img src="{{ route('files.showUserFile', $user->path_signature) }}" alt="Imagen de la firma"
                        style="max-width: 100%;"><br>
                    </div>
            @else
                <div><strong>Firma no asignada</strong></div>
            @endif
        </div>
    </div>

    <div class="col-md-6">

        <form id="permit_form" class="needs-validation" enctype="multipart/form-data" novalidate method="POST" action="{{ route('users.setNewSignature', $user->id) }}">
            @csrf
            @method("PUT")
            <div class="row d-flex flex-column justify-content-center align-items-center gap-1">
                <div class="col-md-9">
                    <canvas id="canvas" class="border border-white rounded" style="width: 100%;"></canvas>
                    <div class="text-center">
                        <label for="canvas"><strong>Firma</strong></label>
                    </div>
                    <input type="hidden" id="signature_data" name="signature_data">
                </div>

                <div class="col-md-9 text-center">
                    @include("components.custom.forms.input", [
                        "id" => "signature_file",
                        "name" => "signature_file",
                        "type" => "file",
                        "placeholder" => "Firma...",
                        "label" => "Subir firma",
                        "value" => old("signature_file"),
                        "accept" => ".png"
                        ])
                    <p>MEDIDAS RECOMENDADAS: 150 X 150</p>
                </div>

                <div class="col-md-12 d-flex justify-content-evenly align-items-center">
                    <div class="col-md-3 btn btn-danger" id="clear_signature">Borrar</div>
                    <button class="col-md-3 btn btn-primary" type="submit">Actualizar Firma</button>
                </div>
            </div>
        </form>

    </div>
</div>