<div class="ms-2 mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
     @if(isset($required))
        <b class="text-danger">*</b>
    @endif
    <textarea id="{{ $id }}" 
              name="{{ $name }}" 
              class="ms-1 form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" 
              rows="4" 
              placeholder="{{ $placeholder ?? '' }}"
              {{isset($readonly) ? $readonly == true ? "readonly" : "" : ""}}
              {{ $required ? 'required' : '' }}>{{ old($name, $value ?? '') }}
            </textarea>
    @if($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @else
        <div class="invalid-feedback">
            {{ $invalid_feedback ?? '' }}
        </div>
    @endif
</div>
