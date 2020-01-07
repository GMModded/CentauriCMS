Centauri.Components.ModulesComponent = function(data) {
    if(data.type == "init") {
        $("#dashboard #modules .module").each(function() {
            $module = $(this);

            $module.on("click", function() {
                var $thismodule = $(this);

                if(Centauri.Components.EditorComponent("isOpen")) {
                    Centauri.fn.Modal(
                        Centauri.__trans.modals.areyousure,
                        Centauri.__trans.modals.editorcomponent_switch,

                        {
                            close: {
                                label: Centauri.__trans.modals.btn_cancel,
                                class: "warning"
                            },

                            save: {
                                label: Centauri.__trans.modals.btn_switch,
                                class: "danger"
                            }
                        },

                        {
                            save() {
                                Centauri.Components.EditorComponent("close");

                                Centauri.Components.ModulesComponent({
                                    type: "switch",
                                    moduleEl: $thismodule
                                });
                            }
                        }
                    );
                } else {
                    Centauri.Components.ModulesComponent({
                        type: "switch",
                        moduleEl: $thismodule
                    });
                }
            });
        });

        setTimeout(function() {
            if(Centauri.elExists($("#dashboard #modules .module.active"))) {
                $("#dashboard #modules .module.active").trigger("click");
            } else {
                if((location.href + "/" == location.origin + Centauri.Utility.PathsUtility.root + Centauri.Utility.PathsUtility.centauri)) {
                    $("#dashboard #modules .module[data-module-id='" + Centauri.defaultModule + "']").trigger("click");
                }
            }
        }, 333);

        $("#dashboard #user i").on("click", function() {
            $("#dashboard #user").toggleClass("active");
            $("#dashboard #user .dropdown-view").slideToggle();
        });
    }

    if(data.type == "switch") {
        $(".overlayer").removeClass("hidden");

        var $module = $(data.moduleEl);
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

                    Centauri.Events.OnModuleLoadEvent(moduleID);
                },

                error: function(data) {
                    $(".overlayer").addClass("hidden");
                }
            }
        );
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

                    Centauri.Events.OnModuleLoadEvent(module);

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
