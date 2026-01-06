<div class="col-12">
    @include("components.custom.forms.input-check", [
        "id" => "is_replacing_on_hired",
        "name" => "is_replacing_on_hired",
        "checked" => false,
        "label" => "Es contratación por remplazo",
    ])
</div>

<div class="col-4">
    @include("components.custom.forms.input-select", [
        "id" => "replacement_for_id",
        "name" => "replacement_for_id",
        "elements" => $replacementUsers,
        "placeholder" => "Remplaza a...",
        "value" => isset($user) ? $user->replacement_for_id :  old("replacement_for_id"),
        "label" => "",
    ])
</div>


<h5 class="text-primary">Importante</h5>
<p>Al momento de hacer remplazo, <b>todos los activos</b> que tenía se asignarán al nuevo usuario</p>