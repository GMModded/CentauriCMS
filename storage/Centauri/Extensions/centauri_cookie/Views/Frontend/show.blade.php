<style>
    #header {
        background: black;
        position: relative !important;
    }

    #header .container-fluid {
        position: relative !important;
    }

    #content {
        padding-top: 0;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="image-view placeholder w-100" style="height: 300px; overflow: hidden;">
            <img class="img-fluid w-100" data-src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($jobItem->headerimage) !!}" />
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="my-5">
                @if($jobItem)
                    <h3>
                        <b>
                            {{ $jobItem->name }}
                        </b>
                    </h3>

                    <hr class="mt-3 mb-4 w-lg-75 ml-0">

                    @if($jobItem->description)
                        <div class="rte-view w-lg-75">
                            {!! $jobItem->description !!}
                        </div>
                    @endif

                    <hr class="mt-4 mb-3 w-lg-75 ml-0">
                @else
                    <h5>
                        This Job couldn't be found anymore or is no longer available.
                    </h5>
                @endif

                <h6>
                    <a class="anim-underline" href="/jobs">
                        <u>
                            Back to the jobs
                        </u>
                    </a>
                </h6>
            </div>
        </div>
    </div>
</div>
