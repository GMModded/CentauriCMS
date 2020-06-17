@php
    $renderHtmlOnly = false;

    if(isset($data->renderHtmlOnly) && $data->renderHtmlOnly) {
        $renderHtmlOnly = true;
    }
@endphp

@if($renderHtmlOnly)
    {!! $data->html !!}
@else
    <div id="{{ $data->pluginid }}">
        <h3>
            {{ $data->plugin->header }}
        </h3>
    </div>

    {!! $data->html !!}
@endif
