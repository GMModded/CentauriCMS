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
                        save: function(formData) {
                            var id = $("#editor").attr("data-id");

                            Centauri.fn.Ajax(
                                "Page",
                                "editPage",

                                {
                                    uid: Centauri.Components.PagesComponent.uid,
                                    title: formData.title,
                                    url: formData.url
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
                        }
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
                                Centauri.fn.Ajax.Overlayer = false;

                                Centauri.fn.Ajax(
                                    "ContentElements",
                                    "findByPid",

                                    {
                                        pid: Centauri.Components.PagesComponent.uid
                                    },

                                    {
                                        success: function(data) {
                                            Centauri.fn.Ajax.Overlayer = true;

                                            var $container = $("#editor > .bottom > .container");
                                            $container.html(data);

                                            /**
                                             * Initializing drag-drop for the elements so they can be moved
                                             */
                                            Centauri.Helper.PagesHelper();

                                            /**
                                             * Registering click-event for newCEButton
                                             */
                                            Centauri.Modal.NewContentElementModal();

                                            var $tops = $(".top", $container);
                                            $tops.each(function() {
                                                var $top = $(this);

                                                $(".edit", $top).on("click", function() {
                                                    var $top = $(this).parent();
                                                    $top.parent().toggleClass("active");

                                                    if(!Centauri.elExists($top.parent().find(".fields"))) {
                                                        Centauri.fn.Ajax(
                                                            "ContentElements",
                                                            "findFieldsByUid",

                                                            {
                                                                uid: $top.parent().attr("data-uid")
                                                            },

                                                            {
                                                                success: function(data) {
                                                                    $(".overlayer").removeClass("hidden");

                                                                    $top.parent().append(data);

                                                                    /**
                                                                     * Initializing CKEditor 5
                                                                     */
                                                                    Centauri.Helper.NewContentElementHelper();

                                                                    $(".fields button").on("click", function() {
                                                                        var uid = $(this).parent().parent().parent().parent().data("uid");
                                                                        var trigger = $(this).data("trigger");

                                                                        if(trigger == "hideElementByUid") {
                                                                            $(this).toggleClass("btn-primary btn-info");
                                                                            $("i", $(this)).toggleClass("fa-eye fa-eye-slash");

                                                                            Centauri.fn.Ajax(
                                                                                "ContentElements",
                                                                                "hideElementByUid",

                                                                                {
                                                                                    uid: uid
                                                                                },

                                                                                {
                                                                                    success: function(data) {
                                                                                        console.log(data);
                                                                                    },

                                                                                    error: function(data) {
                                                                                        console.error(data);
                                                                                    }
                                                                                }
                                                                            )
                                                                        }
                                                                    });

                                                                    $(".fields", $top.parent()).slideDown();
                                                                },

                                                                error: function(data) {
                                                                    console.error(data);
                                                                }
                                                            }
                                                        );
                                                    } else {
                                                        $fields = $top.parent().find(".fields");
                                                        $fields.slideToggle();
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
                            } else {
                                if(data[0] == "/") {
                                    data = data.substring(1, data.length);
                                }

                                data = Centauri.Utility.PathsUtility.root + data;
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
                Centauri.fn.Modal(
                    "Delete this page",
                    "Are you sure to continue deleting this page with all its content?",

                    {
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
                                        var lid = $("#language", $editor).val();
                                        var title = $("#title", $editor).val();
                                        var url = $("#url", $editor).val();

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

    else if(module == "languages") {
        $action = $("table#languages .actions .action");

        $action.on("click", function() {
            $tr = $(this).parent().parent().parent();

            Centauri.Components.PagesComponent.uid = $(this).attr("data-uid");
            var action = $(this).attr("data-action");

            var title = $.trim($("td[data-type='title']", $tr).text());

            if(action == "language-delete") {
                Centauri.fn.Modal(
                    "Delete " + title + " language",
                    "Are you sure to continue deleting the language '" + title + "' with all its bounded content?",

                    {
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
                                "Language",
                                "deleteLanguage",

                                {
                                    uid: Centauri.Components.PagesComponent.uid
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
                );
            }
        });
    }
};

Centauri.Components.PagesComponent.uid = null;

Centauri.Components.PagesComponent.pages = {};
Centauri.Components.PagesComponent.pages.newCEButton = "<button class='btn btn-default m-0 py-2 px-2 waves-effect waves-light' data-action='newContentElement'><i class='fas fa-plus'></i> Content</button>";

Centauri.Components.PagesComponent.languages = {};
