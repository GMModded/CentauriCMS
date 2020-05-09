Centauri.Component.ATagComponent = () => {
    $("a").off("click");

    $("a").on("click", this, function(e) {
        let $this = $(this);
        e.preventDefault();

        let href = $this.attr("href");
        history.pushState({page: 1}, $("title").text(), location.href);

        Centauri.Component.ATagComponent.ajaxRequest(href, () => {
            let seoUrl = Centauri.Utility.SeoUrlUtility($this.text());
            history.pushState({page: 1}, seoUrl, href);

            if($this.hasClass("nav-item")) {
                $("#header a.nav-item.active").removeClass("active");
                $this.addClass("active");
            }
        });
    });

    window.onpopstate = history.onpushstate = function(e) {
        let reqHref = location.href;

        if(reqHref != Centauri.Component.ATagComponent.lastHref) {
            Centauri.Component.ATagComponent.ajaxRequest(reqHref);
        }
    };
};

Centauri.Component.ATagComponent.lastHref = "";

Centauri.Component.ATagComponent.ajaxRequest = (href, cb) => {
    $(".progress").toggleClass("inactive");

    $.ajax({
        type: "POST",
        url: href,

        data: {
            "dynPageRequest": true
        },

        success: function(data) {
            $(".progress").toggleClass("inactive");

            Centauri.Component.ATagComponent.lastHref = href;
            $("body section#content").html(data);
            $("title").text(__dynPageData.title);

            if(typeof cb != "undefined") {
                cb();
            }

            Centauri.Component.ATagComponent();
        }
    });
};
