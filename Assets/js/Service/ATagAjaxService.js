Centauri.Service.ATagAjaxService = function() {
    $("a[data-ajax='true']").on("click", this, function(e) {
        e.preventDefault();

        Centauri.fn.Ajax(
            $(this).data("ajax-handler"),
            $(this).data("ajax-action"),

            {},

            {
                success: function(data) {
                    try {
                        data = JSON.parse(data);
                        Centauri.Notify(data.type, data.title, data.description);
                    } catch(SyntaxError) {}
                }
            }
        )
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
