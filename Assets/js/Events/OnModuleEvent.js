Centauri.Events.OnModuleEvent = function(module) {
    Centauri.Module = module;
    Centauri.Components.PagesComponent(module);

    if(Centauri.DAPLoader.historyPushState) {
        history.pushState({page: 1}, module, Centauri.Utility.PathsUtility.root + "centauri/" + module);
    }

    if(module == "dashboard") {}

    else if(module == "pages") {
        $("#pagemodule_buttons button").each(function() {
            $button = $(this);

            $button.on("click", this, function() {
                var btnType = $(this).data("button-type");

                if(btnType == "refresh") {
                    Centauri.Components.ModulesComponent({
                        type: "load",
                        module: "pages"
                    });
                }

                if($(this).data("button-type") == "create") {
                    Centauri.fn.Ajax(
                        "Page",
                        "getRootPages",

                        {},

                        {
                            success: function(data) {
                                data = JSON.parse(data);
                                var rootpages = data;

                                Centauri.fn.Ajax(
                                    "Page",
                                    "getLanguages",

                                    {},

                                    {
                                        success: function(data) {
                                            data = JSON.parse(data);
                                            var languages = data;

                                            Centauri.Components.EditorComponent("show", {
                                                id: "CreateNewPage",
                                                title: "Page-Editor - New",

                                                form: [
                                                    {
                                                        id: "parent",
                                                        type: "custom",
                                                        custom: "select",

                                                        data: {
                                                            label: "Parent Page",
                                                            options: rootpages
                                                        }
                                                    },

                                                    {
                                                        id: "language",
                                                        type: "custom",
                                                        custom: "select",
                                                        extraAttr: "style='display: none!important;'",

                                                        data: {
                                                            label: "Languages",
                                                            options: languages
                                                        }
                                                    },

                                                    {
                                                        id: "title",
                                                        type: "text",
                                                        label: "Title",
                                                        required: true
                                                    },

                                                    {
                                                        id: "url",
                                                        type: "text",
                                                        label: "URL",
                                                        required: true
                                                    },

                                                    {
                                                        id: "is_rootpage",
                                                        type: "custom",
                                                        custom: "switch",

                                                        data: {
                                                            label: "Root page?",
                                                            isChecked: false,
                                                            onClick: "Centauri.Events.EditorComponent.Checkbox.OnClick(this)"
                                                        }
                                                    }
                                                ],

                                                callbacks: {
                                                    beforeLoaded: function($editor) {
                                                        if(rootpages.length == 0) {
                                                            $("#is_rootpage", $editor).prop("checked", true);
                                                            $("#is_rootpage", $editor).attr("disabled", " ");
                                                            $("form .field #language").parent().parent().removeAttr("style");
                                                            $("form .field #parent").parent().parent().attr("style", "display: none!important;");
                                                        }
                                                    },

                                                    save: function() {
                                                        Centauri.fn.Ajax.Overlayer = false;

                                                        Centauri.fn.Ajax(
                                                            "Page",
                                                            "newPage",

                                                            {
                                                                parentuid: $("#parent", $editor).val(),
                                                                language: $("#language", $editor).val(),
                                                                isrootpage: $("#is_rootpage", $editor).prop("checked"),
                                                                title: $("#CreateNewPage_title", $editor).val(),
                                                                url: $("#CreateNewPage_url", $editor).val()
                                                            },

                                                            {
                                                                success: function(data) {
                                                                    data = JSON.parse(data);
                                                                    Centauri.Notify(data.type, data.title, data.description);

                                                                    Centauri.Components.EditorComponent("clear");
                                                                    Centauri.Components.EditorComponent("hide");

                                                                    Centauri.Components.ModulesComponent({
                                                                        type: "load",
                                                                        module: "pages"
                                                                    });
                                                                },

                                                                error: function(data) {
                                                                    
                                                                },

                                                                complete: function() {
                                                                    Centauri.fn.Ajax.Overlayer = true;
                                                                }
                                                            }
                                                        );
                                                    }//,cancel: function() {}
                                                }
                                            });
                                        },

                                        error: function(data) {
                                            console.error(data);
                                        }
                                    }
                                );
                            }
                        }
                    );
                }
            });
        });
    }

    else if(module == "languages") {
        $("#languagemodule_buttons button").each(function() {
            $button = $(this);

            $button.on("click", this, function() {
                var btnType = $(this).data("button-type");

                if(btnType == "refresh") {
                    Centauri.Components.ModulesComponent({
                        type: "load",
                        module: "languages"
                    });
                }
            });
        });

    } else {
        console.error("Centauri.Events.OnModuleEvent: Module '" + module + "' has not been registered with Centauri.Events.OnModuleEvent!");
    }
};
