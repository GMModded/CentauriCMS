Centauri.Event.OnBreakpointChangeEvent = (_breakpoint) => {
    if(
        _breakpoint == "lg" ||
        _breakpoint == "xl"
    ) {
        if($("> .row", Centauri.Utility.ContentElementUtility("boxitems")).hasClass("slick-slider")) {
            $("> .row", Centauri.Utility.ContentElementUtility("boxitems")).slick("unslick");
        }
    } else {
        if(!$("> .row", Centauri.Utility.ContentElementUtility("boxitems")).hasClass("slick-slider")) {
            $("> .row", Centauri.Utility.ContentElementUtility("boxitems")).slick({
                arrows: false,
                dots: false,
                autoplay: true,
                speed: 750,
                autoplaySpeed: 6500
            });
        }
    }
};
