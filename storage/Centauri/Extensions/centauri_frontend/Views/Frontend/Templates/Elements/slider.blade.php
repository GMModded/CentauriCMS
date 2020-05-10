<div class="container-fluid">
    <div class="row">
        <div data-contentelement="slider" style="max-height: 600px; overflow: hidden; margin-bottom: 0 !important; opacity: 0; transition: .66s ease-in-out;">
            @foreach($element->slideritems as $slideritem)
                <div class="item">
                    @if($slideritem->link)
                        <a href="{{ $slideritem->link }}" style="color: #fff; text-decoration: none;">
                    @endif

                    <div class="overlayer"></div>

                    <div class="image-view" style="min-height: 750px;">
                        @if($slideritem->image)
                            <img class="img-fluid w-100" src="{!! ImageBladeHelper::getPath($slideritem->image) !!}" />
                        @endif
                    </div>

                    <div class="text-view">
                        <h4>
                            {{ $slideritem->title }}
                        </h4>

                        <p style="background: {{ $slideritem->bgcolor }}">
                            {{ $slideritem->teasertext }}
                        </p>

                        @if($slideritem->getButtons())
                            <div class="button-view mt-5">
                                @foreach($slideritem->getButtons() as $button)
                                    @if($button->link && $button->label)
                                        <a href="{{ $button->link }}" target="_blank" role="button">
                                            <button class="waves-effect btn btn-primary{{ ($button->bgcolor == '') || $button->bgcolor == "transparent" ? " transparent" : "" }}" style="background: {{ $button->bgcolor }} !important;">
                                                {{ $button->label }}
                                            </button>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if($slideritem->link)
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
