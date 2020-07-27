@php
    $jsonData = "";
    $renderAs = [];
    $dataRenderAsStr = "";
    $additionalClasses = "";
    $ciFieldAdditionalClasses = "";

    if(isset($fieldConfig["renderAs"]) && !empty($fieldConfig["renderAs"])) {
        $jsonData = json_encode($fieldConfig["renderAs"]);
        $renderAs = $fieldConfig["renderAs"];
    }

    if(isset($renderAs["type"])) {
        $dataRenderAsStr = " data-renderas=" . $renderAs["type"] . "";

        if($renderAs["type"] == "button") {
            $ciFieldAdditionalClasses .= " d-flex";
        }
    }

if(isset($fieldConfig["ciFieldAdditionalClasses"])) {
    $ciFieldAdditionalClasses .= " " . $fieldConfig["ciFieldAdditionalClasses"];
}

if(isset($fieldConfig["additionalClasses"])) {
    $additionalClasses .= " " . $fieldConfig["additionalClasses"];
}
@endphp

<div class="ci-field{{ $ciFieldAdditionalClasses }}"{{ $dataRenderAsStr }}>
    @if($dataRenderAsStr != "")
        @switch($fieldConfig["renderAs"]["type"])
            @case("button")
                <button
                    class="btn btn-default waves-effect waves-light"
                    data-centauri-btn="{{ $jsonData }}"
                    style="padding: 10px 15px;margin: 10px 0;"
                >
                    <i class="fas fa-sync-alt"></i>
                </button>
                @break

            @case("colorpicker")
                <div class="color-picker" class="position-absolute" style="margin-top: 10px;"></div>
                @break
            @default
        @endswitch
    @endif

    <input 
        class="form-control{{ $additionalClasses }}"
        type="text"
        data-id="{{ $fieldConfig['id'] }}"
        value="{{ $fieldConfig['value'] ?? '' }}"
        data-inline-record="{{ isset($fieldConfig['isInlineRecord']) ? 1 : 0 }}"
        {{ (isset($fieldConfig["config"]["required"]) ?? $config["required"] ? " required" : "") }}
        {{ (isset($fieldConfig["config"]["readOnly"]) ?? $config["readOnly"] ? " readonly" : "") }}
        data-uid="{{ $fieldConfig['uid'] }}"
    />

    <label for="{{ $fieldConfig['id'] }}"{{ (isset($fieldConfig["value"]) && (strlen($fieldConfig["value"]) > 0) ? " class=active" : "") }}>
        {{ $fieldConfig["label"] }}
    </label>
</div>
