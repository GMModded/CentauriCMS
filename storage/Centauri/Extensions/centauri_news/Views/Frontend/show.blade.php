<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="my-5">
                @if($newsItem)
                    <h3>
                        <b>
                            {{ $newsItem->title }}
                        </b>
                    </h3>

                    <hr>

                    @if($newsItem->description)
                        {!! $newsItem->description !!}
                    @endif
                @else
                    <h5>
                        This news article couldn't be found anymore or is no longer available.
                    </h5>
                @endif

                <hr>

                <a class="anim-underline" href="/news">
                    <u>
                        Back to the news.
                    </u>
                </a>
            </div>
        </div>
    </div>
</div>
