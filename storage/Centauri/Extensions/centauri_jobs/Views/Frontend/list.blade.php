@if(isset($jobs) && (!empty($jobs)))
    @foreach($jobs as $item)
        <div class="col-12 col-lg-6 item p-0 z-depth-1 waves-effect">
            <a class="anim-underline d-block" href="{!! \Centauri\CMS\BladeHelper\URIBladeHelper::linkAction("\Centauri\Extension\Jobs\Jobs", "show", [
                "uid" => $item->uid,
                "slug" => $item->slug
            ]) !!}">
                <div class="image-view placeholder" style="height: 200px; overflow: hidden;">
                    <img class="img-fluid w-100" data-src="{!! Centauri\CMS\BladeHelper\ImageBladeHelper::getPath($item->headerimage) !!}" />
                </div>

                <div class="p-3">
                    <b>
                        {{ $item["name"] }}
                    </b>
                </div>
            </a>
        </div>
    @endforeach
@else
    <p class="text-center">
        There are no jobs we are looking for at the moment.
    </p>
@endif
