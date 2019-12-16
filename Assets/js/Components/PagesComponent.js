Centauri.Components.PagesComponent = function(module) {
    if(module == "pages") {
        $action = $("table#pages .actions .action");

        $action.on("click", function() {
            $tr = $(this).parent().parent().parent();

            Centauri.Components.PagesComponent.uid = $(this).attr("data-uid");
            var action = $(this).attr("data-action");

            var title = $.trim($("td[data-type='title']", $tr).text());
            var lid = $.trim($("td[data-type='lid']", $tr).attr("data-lid"));
            var flagsrc = $.trim($("td[data-type='lid'] img", $tr).attr("src"));
            var url = $.trim($("td[data-type='url']", $tr).text());
            var created_at = $.trim($("td[data-type='created_at']", $tr).text());
            var updated_at = $.trim($("td[data-type='updated_at']", $tr).text());

            if(action == "page-edit") {
                Centauri.Components.EditorComponent("show", {
                    id: "EditPage-" + Centauri.Components.PagesComponent.uid,
                    title: "Page-Editor - Edit",

                    form: [
                        {
                            id: "uid",
                            label: "UID",
                            type: "text",
                            value: Centauri.Components.PagesComponent.uid,
                            extraAttr: "disabled"
                        },

                        {
                            id: "language",
                            type: "custom",
                            custom: "image",

                            data: {
                                label: "Language",
                                src: flagsrc
                            }
                        },

                        {
                            id: "title",
                            label: "Title",
                            type: "text",
                            value: title,
                            required: true
                        },

                        {
                            id: "url",
                            label: "URL",
                            type: "text",
                            value: url,
                            required: true
                        },

                        {
                            id: "created_at",
                            label: "Created at",
                            type: "text",
                            value: created_at,
                            extraAttr: "disabled"
                        },

                        {
                            id: "updated_at",
                            label: "Updated at",
                            type: "text",
                            value: updated_at,
                            extraAttr: "disabled"
                        }
                    ],

                    callbacks: {
                        save: function() {
                            var id = $("#editor").attr("data-id");

                            Centauri.fn.Ajax(
                                "Page",
                                "editPage",

                                {
                                    uid: Centauri.Components.PagesComponent.uid,
                                    title: $("#" + id + "_title").val(),
                                    url: $("#" + id + "_url").val()
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
                                        console.error(data);
                                    }
                                }
                            );
                        }//,cancel: function() {}
                    }
                });
            }

            if(action == "page-contentelement-edit") {
                var container = "container";

                Centauri.Components.EditorComponent("show", {
                    id: "EditPageContentElement-" + lid + "-" + Centauri.Components.PagesComponent.uid,
                    title: "<img src='" + flagsrc + "' class='img-fluid' style='width: 40px; margin-right: 10px;' /> Page: " + title + " - Content-Element Editor",

                    size: "fluid",
                    container: container,

                    callbacks: {
                        loaded: function($container, exists) {
                            if(!exists) {
                                Centauri.fn.Ajax(
                                    "ContentElements",
                                    "findByPid",

                                    {
                                        pid: 1
                                    },

                                    {
                                        success: function(data) {
                                            var $container = $("#editor > .bottom > .container");
                                            $container.html(data);

                                            /**
                                             * Registering click-event for newCEButton
                                             */
                                            Centauri.Modal.NewContentElementModal();

                                            /**
                                             * Initializing CKEditor 5
                                             */
                                            Centauri.Helper.NewContentElementHelper();

                                            var $tops = $(".top", $container);
                                            $tops.each(function() {
                                                var $top = $(this);

                                                $top.on("click", function() {
                                                    $top = $(this);
                                                    $top.parent().toggleClass("active");

                                                    if(!$top.hasClass("toggling")) {
                                                        $top.addClass("toggling");

                                                        $fields = $top.parent().find(".fields");
                                                        $fields.slideToggle(function() {
                                                            $top.removeClass("toggling");
                                                        });
                                                    }
                                                });
                                            });
                                        }
                                    }
                                );
                            }
                        },

                        save: function() {
                            console.log("save mal");
                        }
                        //,cancel: function() {}
                    }
                });
            }

            if(action == "page-show") {
                Centauri.fn.Ajax(
                    "Page",
                    "showPage",

                    {
                        uid: Centauri.Components.PagesComponent.uid
                    },

                    {
                        success: function(data) {
                            if(data == "/") {
                                data = Centauri.Utility.PathsUtility.root;
                            }

                            window.open(data);
                        },

                        error: function(data) {
                            console.error(data);
                        }
                    }
                );
            }

            if(action == "page-delete") {
                Centauri.Modal(
                    "Delete this page",
                    "Are you sure to continue deleting this page with all its content?",

                    {
                        // size: "lg",

                        close: {
                            label: "Cancel",
                            class: "warning"
                        },

                        save: {
                            label: "Delete",
                            class: "danger"
                        }
                    },

                    {
                        save() {
                            Centauri.fn.Ajax(
                                "Page",
                                "deletePage",

                                {
                                    uid: Centauri.Components.PagesComponent.uid
                                },

                                {
                                    success: function(data) {
                                        data = JSON.parse(data);
                                        if(Centauri.isNotUndefined(data.request)) {
                                            Centauri.Notify("error", "An error occurred!", "Please contact an administrator to handle this internal error.\nError: " + data.request, {
                                                timeOut: -1
                                            });
                                        } else {
                                            Centauri.Notify(data.type, data.title, data.description);
                                        }

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
                        }
                    }
                );
            }

            if(action == "page-translations") {
                Centauri.fn.Ajax(
                    "Page",
                    "getTranslateableLanguages",

                    {
                        uid: Centauri.Components.PagesComponent.uid
                    },

                    {
                        success: function(data) {
                            data = JSON.parse(data);
                            var languages = data;

                            Centauri.Components.EditorComponent("show", {
                                id: "TranslatePage-" + Centauri.Components.PagesComponent.uid,
                                title: "Page-Editor - Translation",

                                form: [
                                    {
                                        id: "language",
                                        type: "custom",
                                        custom: "select",

                                        data: {
                                            label: "Language",
                                            options: languages
                                        }
                                    },

                                    {
                                        id: "copyelements",
                                        type: "custom",
                                        custom: "checkbox",

                                        data: {
                                            label: "Copy elements?",
                                            isChecked: true
                                        }
                                    },

                                    {
                                        id: "title",
                                        label: "Title",
                                        type: "text",
                                        value: title,
                                        required: true
                                    },

                                    {
                                        id: "url",
                                        label: "URL",
                                        type: "text",
                                        value: url,
                                        required: true
                                    }
                                ],

                                callbacks: {
                                    save: function() {
                                        var id = "#TranslatePage-" + Centauri.Components.PagesComponent.uid;

                                        var lid = $("#language", $editor).val();
                                        var title = $(id + "_title", $editor).val();
                                        var url = $(id + "_url", $editor).val();

                                        Centauri.fn.Ajax(
                                            "Page",
                                            "createTranslatedPage",

                                            {
                                                uid: Centauri.Components.PagesComponent.uid,
                                                lid: lid,
                                                title: title,
                                                url: url
                                            },

                                            {
                                                success: function(data) {
                                                    console.log(data);
                                                },

                                                error: function(data) {
                                                    console.error(data);
                                                }
                                            }
                                        );
                                    }
                                    //,cancel: function() {}
                                }
                            });
                        },

                        error: function(data) {
                            console.error(data);
                        }
                    }
                );
            }
        });
    }

    if(module == "languages") {
        $action = $("table#pages .actions .action");

        $action.on("click", function() {
            $tr = $(this).parent().parent().parent();

            Centauri.Components.PagesComponent.uid = $(this).attr("data-uid");
            var action = $(this).attr("data-action");

            var title = $.trim($("td[data-type='title']", $tr).text());
            console.log(action, title);
        });
    }
};

Centauri.Components.PagesComponent.uid = null;

Centauri.Components.PagesComponent.pages = {};
Centauri.Components.PagesComponent.pages.newCEButton = "<button class='btn btn-default m-0 py-2 px-2 waves-effect waves-light' data-action='newContentElement'><i class='fas fa-plus'></i> Content</button>";

Centauri.Components.PagesComponent.languages = {};
