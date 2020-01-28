<div class="md-form">
    <input class="form-control" type="text" id="{{ $id }}" value="{{ $value ?? '' }}"{{ (isset($config["required"]) ?? $config["required"] ? " required" : "")}} />

    <label for="{{ $id }}"{{ (isset($value) ? ' class=active' : '') }}>
        {{ $label }}
    </label>
</div>
