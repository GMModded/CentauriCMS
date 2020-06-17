<div data-contentelement="headerdescription">
    @if($element->header)
        <{{ $element->htag }}>
            {{ $element->header }}
        </{{ $element->htag }}>
    @endif

    @if($element->subheader)
        <h3>
            {{ $element->subheader }}
        </h3>
    @endif

    @if($element->RTE)
        <div class="rte-view">
            {!! $element->RTE !!}
        </div>
    @endif
</div>
