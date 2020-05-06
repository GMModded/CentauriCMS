@if(isset($fieldConfig["renderAs"]))
    @php
        $renderAs = $fieldConfig["renderAs"];
    @endphp
@endif

<div class="md-form{{ isset($renderAs) ? ' has-renderas' : '' }}">
    @if(isset($fieldConfig["renderAs"]))
        @switch($fieldConfig["renderAs"])
            @case("colorpicker")
                <div class="color-picker" class="position-absolute" style="margin-top: 10px;"></div>
                @break
            @default
        @endswitch
    @endif

    <input class="form-control" type="text" id="{{ $fieldConfig['id'] }}" data-id="{{ $fieldConfig['id'] }}" value="{{ $fieldConfig['value'] ?? '' }}" data-inline-record="{{ isset($fieldConfig['isInlineRecord']) ? 1 : 0 }}"{{ (isset($fieldConfig["config"]["required"]) ?? $config["required"] ? " required" : "") }} data-uid="{{ $fieldConfig['uid'] }}" />

    <label for="{{ $fieldConfig['id'] }}"{{ (isset($fieldConfig["value"]) && (strlen($fieldConfig["value"]) > 0) ? " class=active" : "") }}>
        {{ $fieldConfig["label"] }}
    </label>
</div>
