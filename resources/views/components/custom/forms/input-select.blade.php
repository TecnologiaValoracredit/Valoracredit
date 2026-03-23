<label for="{{$id ?? $name}}" class="form-label">{{$label ?? $name}}</label>
@if (isset($addModalBtn) && $addModalBtn == true)
<span class="add-supplier-btn" data-bs-toggle="modal" data-bs-target={{ $targetModal ?? '' }}>+</span>
@endif
@if(isset($required))
    <b class="text-danger">*</b>
@endif
<select class="form-control {{$class ?? ''}}" id="{{$id ?? $name}}" name="{{$name}}" {{isset($required) ? "required" : "" }}     {{isset($readonly) ? $readonly == true ? "readonly" : "" : ""}}    data-tab="{{ $dataTab ?? '' }}">
    <option disabled selected value="">{{ $placeholder ?? 'Seleccione una opción...' }}</option>
    @foreach ($elements as $key => $element)
        <option {{$key == $value ? "selected" : ""}} value="{{$key}}">{{$element}}</option>
    @endforeach
</select>
@if(isset($invalid_feedback))
    <div class="invalid-feedback">
        {{$invalid_feedback}}
    </div>
@endif