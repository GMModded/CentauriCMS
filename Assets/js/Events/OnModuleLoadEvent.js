Centauri.Events.OnModuleLoadEvent = function(module) {
    Centauri.Module = module;
    Centauri.Components.PagesComponent(module);

    if(Centauri.DAPLoader.historyPushState) {
        history.pushState({page: 1}, module, Centauri.Utility.PathsUtility.root + "centauri/" + module);
    }

    if(module == "dashboard") {}

    else if(module == "pages") {
        $("table#pages tr").on("dblclick", this, function() {
            $(".actions .action[data-action='page-edit']", $(this)).trigger("click");
        });

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

                if(btnType == "create") {
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
                                                    loadModuleAfterSaved: "languages",

                                                    beforeLoaded: function($editor) {
                                                        if(rootpages.length == 0) {
                                                            $("#is_rootpage", $editor).prop("checked", true);
                                                            $("#is_rootpage", $editor).attr("disabled", " ");
                                                            $("form .field #language", $editor).parent().parent().removeAttr("style");
                                                            $("form .field #parent", $editor).parent().parent().attr("style", "display: none!important;");
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
                                                                title: $("#title", $editor).val(),
                                                                url: $("#url", $editor).val()
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

                if(btnType == "create") {
                    Centauri.Components.EditorComponent("show", {
                        id: "CreateNewPage",
                        title: "Language-Editor - New",

                        form: [
                            {
                                id: "title",
                                type: "text",
                                label: "Title",
                                required: true
                            },

                            {
                                id: "langcode",
                                type: "text",
                                label: "Lang-Code",
                                required: true
                            },

                            {
                                id: "slug",
                                type: "text",
                                label: "Slug",
                                required: true
                            }
                        ],

                        callbacks: {
                            loadModuleAfterSaved: "languages",

                            save: function(data) {
                                Centauri.fn.Ajax(
                                    "Language",
                                    "newLanguage",

                                    {
                                        title: data.title,
                                        langcode: data.langcode,
                                        slug: data.slug
                                    },

                                    {
                                        success: function(data) {
                                            data = JSON.parse(data);
                                            Centauri.Notify(data.type, data.title, data.description);

                                            Centauri.Components.ModulesComponent({
                                                type: "load",
                                                module: "languages"
                                            });
                                        },

                                        error: function(data) {
                                            console.error(data);
                                        }
                                    }
                                );
                            }
                        }
                    });
                }

                if(btnType == "refresh") {
                    Centauri.Components.ModulesComponent({
                        type: "load",
                        module: "languages"
                    });
                }
            });
        });

    } else {
        console.error("Centauri.Events.OnModuleLoadEvent: Module '" + module + "' has not been registered with Centauri.Events.OnModuleLoadEvent!");
    }
};
