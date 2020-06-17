Centauri.Component.ATagComponent = () => {
    $("a").off("click");

    $("a").on("click", this, function(e) {
        e.preventDefault();

        let $this = $(this);

        let href = $this.attr("href");
        history.pushState({page: 1}, $("title").text(), location.href);

        Centauri.Component.ATagComponent.ajaxRequest(href, () => {
            let seoUrl = Centauri.Utility.SeoUrlUtility($this.text());
            history.pushState({page: 1}, seoUrl, href);

            $(".nav-item.active").removeClass("active");

            let $navItem = $(".nav-item[data-uid='" + __dynPageData.uid + "']");

            if(Centauri.elExists($navItem)) {
                $navItem.addClass("active");
            }
        });
    });

    window.onpopstate = history.onpushstate = function(e) {
        let reqHref = location.href;

        if(reqHref != Centauri.Component.ATagComponent.lastHref) {
            Centauri.Component.ATagComponent.ajaxRequest(reqHref);
        }
    };

    $(window).bind("keydown", function(e) {
        let reload = false;
        let char = String.fromCharCode(e.which).toLowerCase();

        if(e.ctrlKey || e.metaKey) {
            if(char == "r") {
                reload = true;
            }
        }

        if(e.keyCode == 116 || e.key == "F5") {
            reload = true;
        }

        if(reload && Centauri.Component.ATagComponent.canReload) {
            e.preventDefault();

            Centauri.Component.ATagComponent.canReload = false;

            let href = Centauri.Component.ATagComponent.lastHref;
            Centauri.Component.ATagComponent.ajaxRequest(href, () => {
                setTimeout(() => {
                    Centauri.Component.ATagComponent.canReload = true;
                }, 1500);
            });
        } else if(!Centauri.Component.ATagComponent.canReload && reload) {
            e.preventDefault();
        }
    });
};

Centauri.Component.ATagComponent.lastHref = "";
Centauri.Component.ATagComponent.canReload = true;
Centauri.Component.ATagComponent.status = new Response().status;

Centauri.Component.ATagComponent.ajaxRequest = (href, cb) => {
    $(".progress").removeClass("inactive");

    $.ajax({
        type: "POST",
        url: href,

        data: {
            "dynPageRequest": true
        },

        success: (data) => {
            Centauri.Component.ATagComponent.loadPage(href, data, cb);
        },

        error: (jqXHR, textStatus, errorThrown) => {
            if(textStatus == "error") {
                let responseJSON = jqXHR.responseJSON;
                let responseText = jqXHR.responseText;

                let description = (typeof responseJSON != "undefined") ? responseJSON.message : "";

                if(
                    errorThrown == "unknown status" &&
                    description == "CSRF token mismatch."
                ) {
                    console.log("reload");
                    location.reload();
                } else {
                    if(errorThrown == "Not Found") {
                        Centauri.Component.ATagComponent.loadPage(href, responseText, cb);
                    } else {
                        Centauri.Notify("error", errorThrown, description);
                    }
                }
            }
        },

        complete: (jqXHR, textStatus) => {
            $(".progress").addClass("inactive");

            try {
                if(pageNotFound) {
                    location.reload();
                }
            } catch(e) {}
        }
    });
};

Centauri.Component.ATagComponent.loadPage = (href, data, cb = undefined) => {
    Centauri.Component.ATagComponent.lastHref = href;

    $("body section#content").html(data).promise().done(() => {
        $(".progress").toggleClass("inactive");

        if(typeof __dynPageData != "undefined") {
            $("title").text(__dynPageData.title);
        }

        if(Centauri.isNotUndefined(cb)) {
            cb();
        }

        Centauri.Event.OnWindowLoadEvent();
    });
};
