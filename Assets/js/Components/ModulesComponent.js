Centauri.Components.ModulesComponent = function(data) {
    if(data.type == "init") {
        $("#dashboard #modules .module").each(function() {
            $module = $(this);

            $module.on("click", function() {
                $(".overlayer").removeClass("hidden");

                $module = $(this);

                $("#dashboard #modules .module.active").removeClass("active");
                $module.addClass("active");

                var moduleID = $(this).data("module-id");

                CentauriAjax(
                    "Modules",
                    "show",

                    {
                        moduleid: moduleID
                    },

                    {
                        success: function(data) {
                            $(".overlayer").addClass("hidden");
                            $("#content").html(data);

                            var title = $.trim($("#content").find("#title").text());
                            Centauri.Utility.UpdateHeadTags([
                                ["title", title]
                            ]);

                            Centauri.Events.OnModuleEvent(moduleID);
                        },

                        error: function(data) {
                            $(".overlayer").addClass("hidden");
                            console.error(data);
                        }
                    }
                );
            });
        });

        setTimeout(function() {
            $("#dashboard #modules .module[data-module-id='" + Centauri.defaultModule + "']").trigger("click");
        }, 333);

        $("#dashboard #user i").on("click", function() {
            $("#dashboard #user").toggleClass("active");
            $("#dashboard #user .dropdown-view").slideToggle();
        });
    }

    if(data.type == "load") {
        var module = data.module;

        CentauriAjax(
            "Modules",
            "show",

            {
                moduleid: module
            },

            {
                success: function(data) {
                    $(".overlayer").addClass("hidden");
                    $("#content").html(data);

                    var title = $.trim($("#content").find("#title").text());
                    Centauri.Utility.UpdateHeadTags([
                        ["title", title]
                    ]);

                    Centauri.Events.OnModuleEvent(module);
                },

                error: function(data) {
                    $(".overlayer").addClass("hidden");
                    console.error(data);
                }
            }
        );
    }
};
