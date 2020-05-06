Centauri.Service.LazyLoadService = () => {
    $("img[data-src]").each(function() {
        let $img = $(this);

        if($img.inViewport) {
            let src = $img.data("src");

            $img.removeAttr("data-src");
            $img.attr("src", src);
        }
    });
};
