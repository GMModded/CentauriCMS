Centauri.Init.HeaderInit = () => {
    if(!Centauri.Init.HeaderInit.Initialized) {
        Centauri.Init.HeaderInit.Initialized = true;

        let $header = $("#header");
        let $blocks = $(".blocks", $header);

        let height = $blocks.height();
        $blocks.css("top", "-" + height + "px");

        $(".tool", $header).off("dblclick");
        $(".tool", $header).off("click");

        $(".tool", $header).dblclick(function() {
            Centauri.fn.Ajax(
                "Cache",
                "flushAll",

                {},

                {
                    success: function(data) {
                        try {
                            data = JSON.parse(data);
                            Centauri.Notify(data.type, data.title, data.description);

                            Centauri.Events.OnATagAjaxServiceAfter("success", {
                                handler: handler,
                                action: action
                            });
                        } catch(SyntaxError) {
                            Centauri.Events.OnATagAjaxServiceAfter("error", {
                                handler: handler,
                                action: action,
                                error: SyntaxError
                            });
                        }
                    }
                }
            )
        });

        $(".tool", $header).click(function() {
            $(this).toggleClass("active");

            let dataType = $(this).data("type");
            let $el = Centauri.elExists($(".block[data-type='" + dataType + "']", $blocks)) ? $(".block[data-type='" + dataType + "']", $blocks) : null;

            if(Centauri.isNotNull($el)) {
                $el.show();

                $(".overlayer").toggleClass("hidden");
                $blocks.toggleClass("active");
            } else {
                switch(dataType) {
                    case "fullscreen":
                        let $content = $("body > #app > section#maincontent > section#content");
                        let $containers = $("> section > div", $content);

                        if(Centauri.LocalStorage.get("BE_USER_SETTINGS.FULLSCREEN") != "ON") {
                            Centauri.LocalStorage.set("BE_USER_SETTINGS.FULLSCREEN", "ON");

                            if(Centauri.elExists($("style#fullscreen"))) {
                                $("style#fullscreen").html("<style id='fullscreen'>body > #app > section#maincontent > section#content > section > div{max-width: 100% !important; transition: max-width .66s cubic-bezier(1, -.09, 0, 1.16) !important;}/style>");
                            } else {
                                $("body").append("<style id='fullscreen'>body > #app > section#maincontent > section#content > section > div{max-width: 100% !important; transition: max-width .66s cubic-bezier(1, -.09, 0, 1.16) !important;}/style>");
                            }
                        } else {
                            Centauri.LocalStorage.set("BE_USER_SETTINGS.FULLSCREEN", "OFF");
                            $("style#fullscreen").html("<style id='fullscreen'>body > #app > section#maincontent > section#content > section > div{transition: max-width .66s cubic-bezier(1, -.09, 0, 1.16) !important;}/style>");

                            setTimeout(() => {
                                $("style#fullscreen").remove();
                            }, 660);
                        }

                        break;

                    default:
                        break;
                }
            }
        });

        $(document).click(function(e) {
            if(!$(e.target).is($(".tool")) && $blocks.hasClass("active")) {
                $(".tool.active", $blocks).removeClass("active");

                $blocks.removeClass("active");
                $(".overlayer").removeClass("active");

                setTimeout(() => {
                    $(".block", $blocks).hide();
                }, 770);
            }
        });
    }
};

Centauri.Init.HeaderInit.Initialized = false;
