<div data-contentelement="headerimage">
    <div class="image-view" style="position: relative; overflow: hidden; max-height: 200px;">
        <img class="img-fluid w-100" src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($element->image) !!}" />
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 text-view">
                <div class="headings-view">
                    <h1 class="mb-0">
                        {{ $element->header }}
                    </h1>

                    @if($element->subheader)
                        <h3>
                            {{ $element->subheader }}
                        </h3>
                    @endif
                </div>

                @if($element->RTE)
                    <div class="rte-view my-3">
                        {!! $element->RTE !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    [data-contentelement="headerimage"] {
        position: relative;
    }

    [data-contentelement="headerimage"] .image-view::before {content: " ";position: absolute;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(0, 0, 0, .5);}

    [data-contentelement="headerimage"] .text-view {
    }

    [data-contentelement="headerimage"] .headings-view {
        color: white;
        position: absolute;
        top: -100%;
        margin-top: 30px;
    }

    [data-contentelement="headerimage"] .rte-view {
    }
</style>
