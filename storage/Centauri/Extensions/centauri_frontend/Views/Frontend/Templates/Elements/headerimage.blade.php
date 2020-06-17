<div id="headerimage-{{ $element->uid }}" data-contentelement="headerimage">
    @if($element->image)
        <div class="image-view placeholder">
            <img class="img-fluid w-100" data-src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($element->image) !!}" />
        </div>
    @endif

    <div class="text-view">
        {!! $element->RTE !!}
    </div>
</div>

<style>
    #headerimage-{{ $element->uid }} .image-view {
        overflow: hidden;
        height: 600px;
    }
</style>
