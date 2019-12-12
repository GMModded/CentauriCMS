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

                            CentauriAjax(
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

            if(action == "page-contentelement-edit") {
                var backendLayout = null;

                var container = "container";

                Centauri.Components.EditorComponent("show", {
                    id: "EditPageContentElement-" + lid + "-" + Centauri.Components.PagesComponent.uid,
                    title: "<img src='" + flagsrc + "' class='img-fluid' style='width: 40px; margin-right: 10px;' /> Page: " + title + " - Content-Element Editor",

                    size: "fluid",
                    container: container,

                    callbacks: {
                        loaded: function($container, exists) {
                            if(!exists) {
                                CentauriAjax(
                                    "Backend",
                                    "getBackendLayout",

                                    {
                                        pid: Centauri.Components.PagesComponent.uid
                                    },

                                    {
                                        success: function(data) {
                                            var newCEButton = Centauri.Components.PagesComponent.pages.newCEButton;
                                            data = JSON.parse(data);
        
                                            $.each(data, function(rowPos, row) {
                                                $container.append("<div class='row' data-rowPos='" + rowPos + "'></div>");
        
                                                $.each(row, function(a, cols) {
                                                    $.each(cols, function(b, col) {
                                                        $(".row[data-rowPos='" + rowPos + "']", $container).append("<div class='col' data-colPos='" + col + "'>" + newCEButton + "</div>");
                                                    });
                                                });
                                            });
        
                                            CentauriAjax(
                                                "ContentElements",
                                                "findByPid",
        
                                                {
                                                    pid: Centauri.Components.PagesComponent.uid
                                                },
        
                                                {
                                                    success: function(elements) {
                                                        elements = JSON.parse(elements);
        
                                                        $.each(elements, function(index, elementObj) {
                                                            $.each(elementObj, function(subindex, contentElement) {
                                                                $(".col[data-colPos='" + contentElement.colPos + "'").append("<div class='content-element z-depth-1' data-uid='" + contentElement.uid + "'><div class='top waves-effect'><span class='title'>" + contentElement.ctype + "</span><i class='fas fa-sort-down'></i></div><div class='fields' style='display: none;'></div></div>");
        
                                                                $.each(contentElement.data, function(key, value) {
                                                                    $(".content-element[data-uid='" + contentElement.uid + "'] .fields", $container).append("<div class='field'><label>" + key + "</label><input class='form-control' type='text' data-field='" + key + "' value='" + value + "' /></div>");
                                                                });
                                                            });
                                                        });
        
                                                        $tops = $(".top", $container);
                                                        $tops.each(function() {
                                                            $top = $(this);
        
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
                CentauriAjax(
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
                if(confirm("Delete this page?")) {
                    CentauriAjax(
                        "Page",
                        "deletePage",

                        {
                            uid: Centauri.Components.PagesComponent.uid
                        },

                        {
                            success: function(data) {
                                data = JSON.parse(data);
                                if(Centauri.isNotUndefined(data.request)) {
                                    toastr["error"]("An error occurred!", "Please contact an administrator to handle this internal error.\nError: " + data.request, {
                                        timeOut: -1
                                    });
                                } else {
                                    toastr[data.type](data.title, data.description);
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

            if(action == "page-translations") {
                CentauriAjax(
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

                                        CentauriAjax(
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
