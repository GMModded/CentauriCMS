<div class="md-form mt-5">
    <textarea id="{{ $id }}" class="md-textarea form-control" rows="3">{{ $value ?? '' }}</textarea>

    <label for="{{ $id }}"{{ (isset($value) ? ' class=active' : '') }}>
        {{ $label }}
    </label>
</div>
