<div class="form-check">
    <input class="form-check-input" 
            type="checkbox" 
            name="{{$name}}" 
            id="{{$id ?? $name}}"
            {{$checked ? 'checked' : ''}}>
    <label class="form-check-label" for="{{$id ?? $name}}">{{$label}}</label>
</div>