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

@elseif($type == "image"){!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "default") !!}
    <img class="d-none d-xl-block" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "default") !!}" />
    <img class="d-none d-lg-block" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "desktop") !!}" />
    <img class="d-none d-md-block" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "tablet-portrait") !!}" />
    <img class="d-none d-sm-block" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "tablet-landscape") !!}" />
    <img class="d-block d-sm-none" src="{!! \Centauri\CMS\BladeHelper\ImageBladeHelper::findPathByView($fileReference, "mobile") !!}" />

@endif











{{-- @images($fileReferences[0]) --}}

{{-- <div class="image-view">
    <img class="img-fluid" src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($element->image) !!}" />
</div> --}}
