<div class="d-flex input-container">
    <span class="input-group-text" {{ isset($width) ? 'style=width:' . $width . 'px;' : '' }}>
        {{$label ?? $name}}
        @if(isset($required))
            <b class="text-danger">*</b>
        @endif
    </span>
    <div class="w-100">
        <input 
        {{isset($disabled) ? "disabled" : ""}}
        {{isset($required) ? ($required == true ? 'required' : '') : ""}}
        {{isset($readonly) ? "readonly" : ""}}
        {{$type == "number" ? "step=0.0001" : ""}}
        data-Tab="{{ $dataTab ?? '' }}"
        
        type="{{$type}}" id="{{$id}}" class="form-control {{$class ?? ''}}" name="{{$id}}" value="{{$value ?? ''}}" >
        @if ($type == "autocomplete")
            <input type="hidden" name="{{$input_hidden}}" id="{{$input_hidden}}" value="{{$value_hidden ?? ''}}" >
        @endif
    </div>
</div>