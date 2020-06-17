<div class="ci-field mt-5">
    <div class="document-editor__toolbar"></div>

    @php $dataHTML = json_encode($fieldConfig["value"] ?? ""); @endphp

    <div class="ci-textarea form-control" data-id="{{ $fieldConfig["id"] }}" data-html="{{ $dataHTML }}" data-uid="{{ $fieldConfig['uid'] }}" data-inline-record="{{ isset($fieldConfig['isInlineRecord']) ? $fieldConfig['isInlineRecord'] : '0' }}"></div>

    <label for="{{ $fieldConfig["id"] }}"{{ (isset($fieldConfig["value"]) ? ' class=active' : '') }}>
        {{ $fieldConfig["label"] }}
    </label>
</div>
