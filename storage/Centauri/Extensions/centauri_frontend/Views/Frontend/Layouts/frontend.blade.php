@if(\Centauri\Extension\Cookie\Helper\CookiesHelper::getConsentState() != true)
    <script async>
        if(!~document.cookie.indexOf("cookiebox") > 0) {
            var CENTAURI_COOKIE_POPUP_HTML = '<div id="cookiepopupoverlayer"></div><div id="cookiepopup"><div class="wrapper">{COOKIE_HTML}</div></div>';
            var CENTAURI_COOKIE_PAGE_HTML = '{!! str_replace("\n", "", \Centauri\CMS\BladeHelper\PageContentBladeHelper::render(2)) !!}';

            CENTAURI_COOKIE_POPUP_HTML = CENTAURI_COOKIE_POPUP_HTML.replace("{COOKIE_HTML}", CENTAURI_COOKIE_PAGE_HTML);

            document.body.insertAdjacentHTML("afterbegin", CENTAURI_COOKIE_POPUP_HTML);
        }
    </script>
@endif

{!! $contentColHTML !!}
