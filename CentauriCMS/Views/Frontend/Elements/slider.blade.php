<div class="container-fluid">
    <div class="row">
        <div data-contentelement="slider">
            @foreach($element->slideritems as $slideritem)
                <div class="item">
                    <div class="overlayer"></div>
                
                    <div class="image-view">
                        @if($slideritem->image)
                            <img src="{!! ImageBladeHelper::getPath($slideritem->image) !!}" class="img-fluid w-100" />
                        @endif
                    </div>

                    <div class="text-view">
                        <h4>
                            {{ $slideritem->title }}
                        </h4>

                        <p>
                            {{ $slideritem->teasertext }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
