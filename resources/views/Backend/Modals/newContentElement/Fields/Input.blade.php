<div class="md-form">
    <input class="form-control" type="text" id="{{ $id }}" value="{{ $value ?? '' }}" />

    <label for="{{ $id }}"{{ (isset($value) ? ' class=active' : '') }}>
        {{ $label }}
    </label>
</div>
