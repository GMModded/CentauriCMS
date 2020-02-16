<div class="md-form mt-5">
    <div class="document-editor__toolbar"></div>

    @php $dataHTML = json_encode($fieldConfig["value"] ?? ""); @endphp

    <div data-id="{{ $fieldConfig["id"] }}" class="md-textarea form-control" data-html="{{ $dataHTML }}"></div>

    <label for="{{ $fieldConfig["id"] }}"{{ (isset($fieldConfig["value"]) ? ' class=active' : '') }}>
        {{ $fieldConfig["label"] }}
    </label>
</div>
