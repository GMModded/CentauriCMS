Centauri.Components.ModulesComponent = function(data) {
    if(data.type == "init") {
        $("#dashboard #modules .module").each(function() {
            $module = $(this);

            $module.on("click", function() {
                $(".overlayer").removeClass("hidden");

                $module = $(this);
                var moduleID = $module.data("module-id");

                Centauri.fn.Ajax(
                    "Modules",
                    "show",

                    {
                        moduleid: moduleID
                    },

                    {
                        success: function(data) {
                            $("#dashboard #modules .module.active").removeClass("active");
                            $module.addClass("active");

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
            if(Centauri.elExists($("#dashboard #modules .module.active"))) {
                $("#dashboard #modules .module.active").trigger("click");
            } else {
                $("#dashboard #modules .module[data-module-id='" + Centauri.defaultModule + "']").trigger("click");
            }
        }, 333);

        $("#dashboard #user i").on("click", function() {
            $("#dashboard #user").toggleClass("active");
            $("#dashboard #user .dropdown-view").slideToggle();
        });
    }

    if(data.type == "load") {
        var module = data.module;

        Centauri.fn.Ajax(
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

                    Centauri.DAPLoader.historyPushState = true;
                },

                error: function(data) {
                    $(".overlayer").addClass("hidden");
                    console.error(data);
                }
            }
        );
    }
};
