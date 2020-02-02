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
            $(".overlayer").toggleClass("hidden");
            $blocks.toggleClass("active");
        });

        $(document).click(function(e) {
            if(
                !$(e.target).is($(".tool"))
            &&
                $blocks.hasClass("active")
            ) {
                $blocks.removeClass("active");
            }
        });
    }
};

Centauri.Init.HeaderInit.Initialized = false;
