Centauri.Service.LazyService = () => {
    Centauri.Service.LazyService.Slider("init");
};

Centauri.Service.LazyService.Slider = (type) => {
    let $slider = Centauri.Utility.ContentElementUtility("slider");

    if($slider.inViewport() && !$slider.hasClass("lazy-loaded")) {
        $(".image-view img[data-src]", $slider).each(function(index) {
            if((type == "init" || type == "scroll")) {
                let $img = $(this);

                let src = $img.data("src");
                $img.attr("src", src);

                let image = new Image();
                image.src = src;

                image.onload = () => {
                    $img.removeClass("d-none");
                    $img.removeAttr("data-src");
                };

                if(type == "init" && index == 0) {
                    console.log("END");
                    return false;
                } else if(type == "scroll") {
                    $slider.addClass("lazy-loaded");
                }
            }
        });
    }

    $(window).on("scroll", this, function() {
        Centauri.Service.LazyService.Slider("scroll");
    });
};
