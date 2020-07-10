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

    @if($element->rte)
        <div class="rte-view">
            {!! $element->rte !!}
        </div>
    @endif
</div>
