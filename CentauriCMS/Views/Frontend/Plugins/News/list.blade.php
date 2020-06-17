<div class="container">
    <div class="row">
        <div class="col jumbotron">
            @foreach($news as $newsItem)
                {{ $newsItem->title }}

                <strong>{!! $newsItem->teasertext !!}</strong>
            @endforeach
        </div>
    </div>
</div>
