Centauri.Service.ATagAjaxService = function() {
    $("a[data-ajax='true']").on("click", this, function(e) {
        e.preventDefault();

        let handler = $(this).data("ajax-handler");
        let action = $(this).data("ajax-action");

        Centauri.Events.OnATagAjaxServiceBefore({
            handler,
            action
        });

        Centauri.fn.Ajax(
            handler,
            action,

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
        );
    });

    $("a[data-module='true']").on("click", this, function(e) {
        e.preventDefault();
        var moduleid = $(this).data("moduleid");
    
        Centauri.Components.ModulesComponent({
            type: "load",
            module: moduleid
        });
    });
};
