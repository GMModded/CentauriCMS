@php
    $checked = "";

    if($fieldConfig["value"] ?? "0" == "1") {
        $checked = "checked='checked'";
    }
@endphp

<div class="ci-switch">
    <label for="{{ $fieldConfig['id'] }}">
        <input type="checkbox" id="{{ $fieldConfig['id'] }}" data-id="{{ $fieldConfig['id'] }}" data-uid="{{ $fieldConfig['uid'] }}"{{ $checked }} />
        <span></span>

        {{ $fieldConfig["label"] }}
    </label>
</div>
