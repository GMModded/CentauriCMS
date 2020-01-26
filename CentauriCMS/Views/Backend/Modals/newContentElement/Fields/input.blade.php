<div class="md-form">
    <input class="form-control" type="text" data-id="{{ $id }}" value="{{ $value ?? '' }}" />

    <label for="{{ $id }}"{{ (isset($value) ? ' class=active' : '') }}>
        {{ $label }}
    </label>
</div>
