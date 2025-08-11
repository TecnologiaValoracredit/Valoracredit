        <label for="{{$id ?? $name}}" class="form-label">{{$label ?? $name}}</label>

        @if(isset($required))
            <b class="text-danger">*</b>
        @endif
        <input 
        {{isset($disabled) ? "disabled" : ""}}
        {{isset($required) ? ($required == true ? 'required' : '') : ""}}
        {{isset($readonly) ? "readonly" : ""}}
        {{$type == "number" ? "step=0.0001" : ""}}
        
        type="{{$type}}" id="{{$id}}" class="form-control {{$class ?? ''}}" name="{{$id}}" value="{{$value ?? ''}}" >
        @if ($type == "autocomplete")
            <input type="hidden" name="{{$input_hidden}}" id="{{$input_hidden}}" value="{{$value_hidden ?? ''}}" >
        @endif