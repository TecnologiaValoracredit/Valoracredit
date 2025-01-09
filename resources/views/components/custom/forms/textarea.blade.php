<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea id="{{ $id }}" 
              name="{{ $name }}" 
              class="form-control {{ $errors->has($name) ? 'is-invalid' : '' }}" 
              placeholder="{{ $placeholder ?? '' }}" 
              {{ $required ? 'required' : '' }}>{{ old($name, $value ?? '') }}</textarea>
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
