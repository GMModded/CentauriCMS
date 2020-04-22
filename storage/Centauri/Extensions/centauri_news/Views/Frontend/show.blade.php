<style>
    #header {
        background: black;
        position: relative !important;
    }

    #header .container-fluid {
        position: relative !important;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="my-5 text-center">
                @if($newsItem)
                    <h3>
                        {{ $newsItem->title }}
                    </h3>

                    <hr>

                    @if($newsItem->description)
                        {!! $newsItem->description !!}
                    @endif
                @else
                    <h5>
                        Dieser News-Artikel ist leider nicht mehr verfügbar bzw. konnte nicht gefunden werden.
                    </h5>
                @endif

                <h6>
                    <a href="/news">
                        Zurück zu den News
                    </a>
                </h6>
            </div>
        </div>
    </div>
</div>
