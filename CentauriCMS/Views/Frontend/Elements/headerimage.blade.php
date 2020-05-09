<div data-contentelement="headerimage">
    <div class="image-view" style="position: relative; overflow: hidden; max-height: 600px;">
        <img class="img-fluid w-100" src="{!! ImageBladeHelper::getPath($element->image) !!}" />
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 text-view">
                <div class="headings-view">
                    <h1 class="mb-0">
                        {{ $element->header }}
                    </h1>

                    <h3>
                        {{ $element->subheader }}
                    </h3>
                </div>

                <div class="rte-view">
                    {!! $element->RTE !!}
                </div>
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
        position: relative;
        margin-top: -160px;
        margin-bottom: 160px;
    }

    [data-contentelement="headerimage"] .headings-view {
        color: white;
    }

    [data-contentelement="headerimage"] .rte-view {
        color: black;
        margin: 80px 0 -160px 0;
    }
</style>
