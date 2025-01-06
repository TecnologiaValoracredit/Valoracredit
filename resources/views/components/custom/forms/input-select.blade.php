<label for="{{$id ?? $name}}" class="form-label">{{$label ?? $name}}</label>
<select class="form-control {{$class ?? ''}}" id="{{$id ?? $name}}" name="{{$name}}" {{isset($required) ? "required" : ""}}>
    <option disabled selected value="">Seleccione una opción...</option>
    @foreach ($elements as $key => $element)
        <option {{$key == $value ? "selected" : ""}} value="{{$key}}">{{$element}}</option>
    @endforeach
</select>
@if(isset($invalid_feedback))
    <div class="invalid-feedback">
        {{$invalid_feedback}}        
    </div>
@endif