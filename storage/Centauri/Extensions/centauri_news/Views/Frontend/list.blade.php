@if(isset($news) && (!empty($news)))
    @foreach($news as $item)
        <div class="col-12 col-lg-6 item p-0 z-depth-1">
            <a class="anim-underline d-block" href="{!! \Centauri\CMS\BladeHelper\URIBladeHelper::linkAction("\Centauri\Extension\News\News", "show", [
                "uid" => $item->uid,
                "slug" => $item->slug
            ]) !!}">
                <div class="p-3">
                    <b>
                        {{ $item["title"] }}
                    </b>
                </div>
            </a>
        </div>
    @endforeach
@else
    <p class="text-center">
        No News found.
    </p>
@endif
