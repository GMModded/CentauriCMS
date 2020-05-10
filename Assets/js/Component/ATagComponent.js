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

            $(".nav-item.active").removeClass("active");

            if($this.hasClass("nav-item")) {
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
            Centauri.Component.ATagComponent.lastHref = href;
            $("body section#content").html(data);
            $("title").text(__dynPageData.title);

            if(typeof cb != "undefined") {
                cb();
            }

            Centauri.Event.OnWindowLoadEvent();
        },

        error: function(jqXHR, textStatus, errorThrown) {
            if(textStatus == "error") {
                let responseJSON = jqXHR.responseJSON;
                let description = (typeof responseJSON != "undefined") ? responseJSON.message : "";

                console.table(jqXHR);

                if(
                    errorThrown == "unknown status" &&
                    description == "CSRF token mismatch."
                ) {
                    location.href = "/";
                } else {
                    Centauri.Notify("error", errorThrown, description);
                }
            }
        },

        complete: function() {
            $(".progress").toggleClass("inactive");
        }
    });
};
