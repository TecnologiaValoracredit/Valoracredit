<input 
type="radio" 
class="form-check-input" 
name="{{ $name }}"
id="{{ $id ?? $name }}"
value="{{ $value }}"
{{ isset($checked) ? "checked" : '' }}
>

<label for="{{ $id ?? $name }}" class="form-check-label">{{ $label ?? $name }}</label>
