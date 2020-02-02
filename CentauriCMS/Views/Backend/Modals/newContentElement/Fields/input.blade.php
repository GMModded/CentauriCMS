<div class="md-form">
    <input class="form-control" type="text" id="{{ $id }}" data-id="{{ $id }}" value="{{ $value ?? '' }}" data-inline-record="{{ isset($isInlineRecord) ? 1 : 0 }}"{{ (isset($config["required"]) ?? $config["required"] ? " required" : "") }} />

    <label for="{{ $id }}"{{ (isset($value) ? ' class=active' : '') }}>
        {{ $label }}
    </label>
</div>
