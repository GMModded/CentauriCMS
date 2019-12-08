Centauri.Events.OnModuleEvent = function(module) {
    if(module == "pages") {
        Centauri.Components.PagesComponent();

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

                                Centauri.Components.EditorComponent("show", {
                                    id: "CreateNewPage",
                                    title: "Page-Editor - New",

                                    form: [
                                        {
                                            id: "parent",
                                            type: "custom",
                                            custom: "select",

                                            data: {
                                                label: "Parent-Page",
                                                options: rootpages
                                            }
                                        },

                                        {
                                            id: "title",
                                            type: "text",
                                            placeholder: "Title"
                                        },

                                        {
                                            id: "url",
                                            type: "text",
                                            placeholder: "URLs"
                                        },

                                        {
                                            id: "is_rootpage",
                                            type: "custom",
                                            custom: "switch",

                                            data: {
                                                label: "Root page?",
                                                isChecked: false,
                                                onClick: Centauri.Events.EditorComponent.Checkbox.OnClick
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

                                        afterFormInitialized: function($editor) {
                                            if(rootpages.length == 0) {
                                                Centauri.Components.EditorComponent.FormData[0] = {
                                                    id: "language",
                                                    type: "custom",
                                                    custom: "select",

                                                    data: {
                                                        label: "Parent-Page",
                                                        options: [
                                                            {
                                                                name: "English",
                                                                value: 1
                                                            },

                                                            {
                                                                name: "Deutsch",
                                                                value: 2
                                                            }
                                                        ]
                                                    }
                                                };
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
                                                    title: $("#CreateNewPage_title").val(),
                                                    url: $("#CreateNewPage_url").val()
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
                            }
                        }
                    )
                }
            });
        });
    } else {
        console.error();
    }
};
