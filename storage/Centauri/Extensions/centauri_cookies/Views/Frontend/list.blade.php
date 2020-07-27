<hr>

@foreach($cookies as $cookie)
    <div class="row my-3">
        <div class="col-12">
            <div class="cookie">
                <div class="ci-switch">
                    <label 
                        {{ ($cookie->state ? " class=is-state" : "") }}
                        for="{!! Centauri\CMS\BladeHelper\StringToUniqueIdBladeHelper::conv($cookie->name) !!}"
                    >
                        <input 
                            type="checkbox"
                            class="parent"
                            name="{!! Centauri\CMS\BladeHelper\StringToUniqueIdBladeHelper::conv($cookie->name) !!}"
                            id="{!! Centauri\CMS\BladeHelper\StringToUniqueIdBladeHelper::conv($cookie->name) !!}"
                            {{ ($cookie->state ? " checked=checked readonly=readonly disabled=disabled" : "") }}
                        />

                        <span></span>

                        {{ $cookie->name }}
                    </label>
                </div>

                <p class="show-more d-inline">
                    <small style="cursor: pointer;">
                        Mehr erfahren
                    </small>
                </p>

                <div class="childcookies pl-3 d-none">
                    @foreach($cookie->getChildCookies() as $childcookie)
                        <div class="row">
                            <div class="col-12">
                                <div class="ci-switch">
                                    <label 
                                        {{ ($cookie->state ? " class=is-state" : "") }}
                                        for="{!! Centauri\CMS\BladeHelper\StringToUniqueIdBladeHelper::conv($childcookie->name) !!}"
                                    >
                                        <input 
                                            type="checkbox"
                                            class="child"
                                            name="{!! Centauri\CMS\BladeHelper\StringToUniqueIdBladeHelper::conv($childcookie->name) !!}"
                                            id="{!! Centauri\CMS\BladeHelper\StringToUniqueIdBladeHelper::conv($childcookie->name) !!}"
                                            {{ ($cookie->state ? " checked=checked readonly=readonly disabled=disabled" : "") }}
                                        />

                                        <span></span>

                                        {{ $childcookie->name }}
                                    </label>

                                    <div class="description pl-3">
                                        {!! $childcookie->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
    </div>
@endforeach

<hr class="mt-3">

<div class="row bottom-row">
    <div class="col px-0">
        <button id="cookiepopup_cookies_acceptselected" class="btn btn-default waves-effect">
            Auswahl akzeptieren
        </button>
    </div>

    <div class="col px-0">
        <button id="cookiepopup_cookies_acceptall" class="btn btn-primary waves-effect">
            Alle akzeptieren
        </button>
    </div>
</div>
