@php
    $fileReference = $fileReferences[0];
    $datas = $fileReference->getData();

    # Can be either "picture" or "image"
    $type = "image";
@endphp

@if($type == "picture")
    <picture>
        <source media="(min-width: 1200px)" srcset="">
    </picture>

@elseif($type == "image")
    <img class="img-fluid rounded default" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "default") !!}" />
    <img class="img-fluid rounded desktop" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "desktop") !!}" />
    <img class="img-fluid rounded tablet-portrait" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "tablet-portrait") !!}" />
    <img class="img-fluid rounded tablet-landscape" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "tablet-landscape") !!}" />
    <img class="img-fluid rounded mobile" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "mobile") !!}" />

@endif











{{-- @images($fileReferences[0]) --}}

{{-- <div class="image-view">
    <img class="img-fluid" src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($element->image) !!}" />
</div> --}}
