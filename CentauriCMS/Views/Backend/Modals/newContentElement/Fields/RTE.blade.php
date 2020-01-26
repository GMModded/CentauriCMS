<div class="md-form mt-5">
    <div class="document-editor__toolbar"></div>

    @php $dataHTML = json_encode($value ?? ""); @endphp

    <div data-id="{{ $id }}" class="md-textarea form-control" data-html="{{ $dataHTML }}"></div>

    <label for="{{ $id }}"{{ (isset($value) ? ' class=active' : '') }}>
        {{ $label }}
    </label>
</div>
