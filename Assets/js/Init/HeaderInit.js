Centauri.Init.HeaderInit = () => {
    if(!Centauri.Init.HeaderInit.Initialized) {
        Centauri.Init.HeaderInit.Initialized = true;

        let $header = $("#header");
        let $blocks = $(".blocks", $header);

        let height = $blocks.height();
        $blocks.css("top", "-" + height + "px");

        $(".tool", $header).each(function() {
            let $tool = $(this);

            $tool.dblclick(() => {
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

            $tool.click(() => {
                let type = $(this).data("type");
                let $block = $(".block[data-type='" + type + "']", $blocks);

                $(".overlayer").toggleClass("hidden");
                $blocks.toggleClass("active");
            });
        });

        $(document).click((e) => {
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
