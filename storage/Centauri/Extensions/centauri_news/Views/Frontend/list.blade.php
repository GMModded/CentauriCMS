<div class="container">
    @if(isset($news) && (!empty($news)))
        <div class="row">
            @foreach($news as $item)
                <div class="col-12 col-md-6">
                    <div class="item p-3" style="border: 1px solid;">
                        <a href="{!! URIBladeHelper::linkAction("\Centauri\Extension\News", "show", [
                            "uid" => $item->uid,
                            "slug" => $item->title
                        ]) !!}">
                            <b>
                                {{ $item["title"] }}
                            </b>

                            <br/>

                            » {{ $item["author"] }}

                            <hr>

                            <p>
                                teaserrr
                            </p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
