Centauri.Events.OnModuleEvent = function(module) {
    Centauri.Module = module;
    Centauri.Components.PagesComponent(module);

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
                    CentauriAjax(
                        "Page",
                        "getRootPages",

                        {},

                        {
                            success: function(data) {
                                data = JSON.parse(data);
                                var rootpages = data;

                                CentauriAjax(
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
                                                        }
                                                    },

                                                    save: function() {
                                                        CentauriAjax(
                                                            "Page",
                                                            "newPage",

                                                            {
                                                                parentuid: $("#parent", $editor).val(),
                                                                language: $("#language", $editor).val(),
                                                                is_rootpage: $("#is_rootpage", $editor).prop("checked"),
                                                                title: $("#title").val(),
                                                                url: $("#url").val()
                                                            },

                                                            {
                                                                success: function(data) {
                                                                    data = JSON.parse(data);
                                                                    toastr[data.type](data.title, data.description);

                                                                    Centauri.Components.EditorComponent("clear");
                                                                    Centauri.Components.EditorComponent("hide");

                                                                    Centauri.Components.ModulesComponent({
                                                                        type: "load",
                                                                        module: "pages"
                                                                    });
                                                                },

                                                                error: function(data) {
                                                                    console.error(data);
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
