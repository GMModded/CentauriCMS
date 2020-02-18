<div class="container-fluid">
    <div class="row">
        <div data-contentelement="slider" style="max-height: 550px; overflow: hidden; margin-bottom: 0 !important;">
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

                        @if($slideritem->buttons())
                            <div class="button-view mt-5">
                                @foreach($slideritem->buttons() as $button)
                                    @if($button->link && $button->label)
                                        <a href="{{ $button->link }}" target="_blank">
                                            <button class="waves-effect btn btn-primary{{ ($button->bgcolor == '') || $button->bgcolor == "transparent" ? " transparent" : "" }}" style="background: {{ $button->bgcolor }};">
                                                {{ $button->label }}
                                            </button>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
