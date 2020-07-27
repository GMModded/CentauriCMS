@if(\Centauri\Extension\Cookie\Helper\CookiesHelper::getConsentState() != true)
    <div id="cookiepopupoverlayer"></div>

    <div id="cookiepopup" class="hidden">
        <div class="wrapper">
            {!! \Centauri\CMS\BladeHelper\PageContentBladeHelper::render(2) !!}
        </div>
    </div>
@endif

{!! $contentColHTML !!}
