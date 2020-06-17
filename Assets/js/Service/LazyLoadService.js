Centauri.Service.LazyLoadService = () => {
    $(".placeholder").each(function() {
        let $element = null;

        if(Centauri.elExists($("img", $(this)))) {
            $element = $("img", $(this));
        }

        if(Centauri.elExists($("div", $(this)))) {
            $element = $("div", $(this));
        }

        if(Centauri.isNotNull($element)) {
            if($element.is($("img"))) {
                let $img = $(this);

                if($img.inViewport()) {
                    $img = $("img", $img);
                    let src = $img.data("src");
                    let image = new Image();

                    $img.removeAttr("data-src");
                    $img.attr("src", src);

                    image.src = src;
                    image.onload = () => {
                        $img.parent().removeClass("placeholder");
                    };
                }   
            } else {
                console.warn("PlaceholderService has no support yet for: " + $element);
            }
        }
    });
};
