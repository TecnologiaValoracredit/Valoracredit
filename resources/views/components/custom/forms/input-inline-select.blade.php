<div class="d-flex input-container">
    <span class="input-group-text" {{ isset($width) ? 'style=width:' . $width . 'px;' : '' }}>
        {{$label ?? $name}}
        @if(isset($required))
            <b class="text-danger">*</b>
        @endif
    </span>
    <div class="w-100">
        <select 
            class="form-control" 
            id="{{ $id ?? $name }}" 
            name="{{ $name }}" 
            {{ isset($required) ? "required" : "" }}
            {{ isset($disabled) && $disabled ? 'disabled' : '' }}
        >
            @if(isset($required))
                <option disabled selected value="">Seleccione una opción...</option>
            @else
                <option selected value="">Seleccione una opción...</option>
            @endif    
            @foreach ($elements as $key => $element)
                <option {{ $key == $value ? "selected" : "" }} value="{{ $key }}">{{ $element }}</option>
            @endforeach
        </select>
    </div>
</div>
