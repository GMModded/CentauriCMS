<div id="headerimage-{{ $element->uid }}" data-contentelement="headerimage">
    @if($element->image)
        <div class="image-view">
        </div>
    @endif

    <div class="text-view">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div style="background: {{ $element->bgoverlayer }}; border-radius: 5px; padding: 15px 0; margin: 0 -15px;">
                        {!! $element->RTE !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #headerimage-{{ $element->uid }} .text-view div > h1 > span:nth-child(2) {
        color: gold !important;
    }

    #headerimage-{{ $element->uid }} .text-view div > h1 > span:nth-child(4) {
        color: hotpink !important;
    }
</style>
