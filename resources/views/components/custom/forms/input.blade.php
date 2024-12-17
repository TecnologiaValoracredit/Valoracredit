<label for="{{$id ?? $name}}" class="form-label">{{$label ?? $name}}</label>
<input 
    name="{{$name}}" 
    type="{{$type ?? 'text'}}" 
    class="form-control {{$class ?? ''}}"
    id="{{$id ?? $name}}"
    value="{{$value ?? ''}}" 
    placeholder="{{$placeholder ?? ''}}"
    {{isset($required) ? "required" : ""}}
>

@if(isset($valid_feedback))
    <div class="valid-feedback">
        {{$valid_feedback}}        
    </div>
@endif
@if(isset($invalid_feedback))
    <div class="invalid-feedback">
        {{$invalid_feedback}}        
    </div>
@endif

<!-- 
    id
    class
    type
    value,
    required,
    valid-feedback
    invalid-feedback
-->