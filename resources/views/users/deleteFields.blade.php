<div class="row mb-2">
    <div class="col-4">
        <label for="termination_reason_id" class="form-label">Motivo de baja</label>
        <select id="termination_reason_id" class="form-control">
            <option value="">Seleccione motivo</option>
            @foreach($terminationReasons as $reason)
                <option data-children="{{ $reason->hasChildren() }}" value="{{ $reason->id }}">{{ $reason->name }}</option>
            @endforeach
        </select>
    </div>
</div>

