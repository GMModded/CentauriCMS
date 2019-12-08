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

                                console.log(rootpages);

                                Centauri.Components.EditorComponent("show", {
                                    id: "CreateNewPage",
                                    title: "Page-Editor - New",

                                    form: [
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
                                            id: "parent",
                                            type: "custom",
                                            custom: "select",

                                            data: {
                                                label: "Parent-Page",
                                                options: rootpages
                                            }
                                        }
                                    ],

                                    callbacks: {
                                        save: function() {
                                            CentauriAjax(
                                                "Page",
                                                "newPage",

                                                {
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
