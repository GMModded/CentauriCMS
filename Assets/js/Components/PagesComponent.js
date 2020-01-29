Centauri.Components.PagesComponent = function(module) {
    Centauri.Components.PagesComponent.uid = null;

    Centauri.Components.PagesComponent.pages = {};
    Centauri.Components.PagesComponent.pages.newCEButton = "<button class='btn btn-default m-0 py-2 px-2 waves-effect waves-light' data-action='newContentElement'><i class='fas fa-plus'></i> " + Centauri.__trans.modals.btn_content + "</button>";

    Centauri.Components.PagesComponent.languages = {};


    if(module == "pages") {
        $action = $("table#pages .actions .action");

        $action.on("click", function() {
            $tr = $(this).parent().parent().parent().parent();

            Centauri.Components.PagesComponent.uid = $(this).attr("data-uid");
            var action = $(this).attr("data-action");

            var domain_id = $.trim($("td[data-type='domain_id']", $tr).text());
            var title = $.trim($("td[data-type='title']", $tr).text());
            var lid = $.trim($("td[data-type='lid']", $tr).attr("data-lid"));
            var flagsrc = $.trim($("td[data-type='lid'] img", $tr).attr("src"));
            var url = $.trim($("td[data-type='url']", $tr).text());
            var created_at = $.trim($("td[data-type='created_at']", $tr).text());
            var updated_at = $.trim($("td[data-type='updated_at']", $tr).text());

            if(action == "actions-trigger") {
                $(this).toggleClass("active");
            }

            if(action == "page-edit") {
                let urlObject = {
                    id: "url",
                    label: "URL (Domain)",
                    type: "text",
                    value: url,
                    extraAttr: "disabled"
                };

                if($tr.hasClass("subpage")) {
                    urlObject = {
                        id: "url",
                        label: "URL",
                        type: "text",
                        value: url,
                        required: true
                    };
                }

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
                                label: Centauri.__trans.global.label_language,
                                src: flagsrc
                            }
                        },

                        {
                            id: "title",
                            label: Centauri.__trans.global.label_language,
                            type: "text",
                            value: title,
                            required: true
                        },

                        urlObject,

                        {
                            id: "created_at",
                            label: Centauri.__trans.global.label_createdat,
                            type: "text",
                            value: created_at,
                            extraAttr: "disabled"
                        },

                        {
                            id: "updated_at",
                            label: Centauri.__trans.global.label_modifiedat,
                            type: "text",
                            value: updated_at,
                            extraAttr: "disabled"
                        }
                    ],

                    callbacks: {
                        save: function(formData) {
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

                                        Centauri.Components.EditorComponent("close");

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
                                Centauri.Helper.findByPidHelper(Centauri.Components.PagesComponent.uid);
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
                    Centauri.__trans.modals.deletePage_title,
                    Centauri.__trans.modals.deletePage_body,

                    {
                        id: "areyousure_deletepage",

                        close: {
                            label: Centauri.__trans.modals.btn_cancel,
                            class: "warning"
                        },

                        save: {
                            label: Centauri.__trans.modals.btn_delete,
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
                                            label: Centauri.__trans.global.label_language,
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
                                        label: Centauri.__trans.global.label_title,
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

    else if(module == "domains") {
        $action = $("table#domains .actions .action");

        $action.on("click", function() {
            $tr = $(this).parent().parent().parent().parent();

            var action = $(this).attr("data-action");

            if(action == "actions-trigger") {
                $(this).toggleClass("active");
            }

            if(action == "domain-edit" || action == "domain-delete") {
                $tr = $(this).parent().parent().parent();

                var id = $(this).attr("data-id");
                var rootpageuid = $(this).attr("data-rootpageuid");
                var domain = $.trim($("[data-type='domain']", $tr).text());

                if(action == "domain-edit") {
                    Centauri.fn.Ajax(
                        "Page",
                        "getRootPages",

                        {},

                        {
                            success: function(data) {
                                data = JSON.parse(data);
                                var rootpages = data;

                                Centauri.Components.EditorComponent("show", {
                                    id: "EditDomain-" + id,
                                    title: "Domain-Editor",

                                    form: [
                                        {
                                            id: "rootpageuid",
                                            type: "custom",
                                            custom: "select",

                                            data: {
                                                selectedOptionValue: rootpageuid,
                                                label: "Rootpages",
                                                options: rootpages,
                                                required: true
                                            }
                                        },

                                        {
                                            id: "id",
                                            label: "ID",
                                            type: "text",
                                            value: id,
                                            extraAttr: "disabled"
                                        },

                                        {
                                            id: "domain",
                                            label: "Domain",
                                            type: "text",
                                            value: domain,
                                            required: true
                                        }
                                    ],

                                    callbacks: {
                                        save: function(formData) {
                                            Centauri.fn.Ajax(
                                                "Domains",
                                                "edit",

                                                {
                                                    id: id,
                                                    rootpageuid: formData.rootpageuid,
                                                    domain: formData.domain
                                                },

                                                {
                                                    success: function(data) {
                                                        data = JSON.parse(data);
                                                        Centauri.Notify(data.type, data.title, data.description);

                                                        Centauri.Components.EditorComponent("close");

                                                        Centauri.Components.ModulesComponent({
                                                            type: "load",
                                                            module: "domains"
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
                        }
                    );
                }

                if(action == "domain-delete") {
                    Centauri.fn.Modal(
                        Centauri.__trans.modals.areyousure,
                        "Do you want to continue deleting this domain-record?",

                        {
                            id: "areyousure_deletedomainrecord",
    
                            close: {
                                label: Centauri.__trans.modals.btn_cancel,
                                class: "warning"
                            },

                            save: {
                                label: Centauri.__trans.modals.btn_delete,
                                class: "danger"
                            }
                        },

                        {
                            save() {
                                Centauri.fn.Ajax(
                                    "Domains",
                                    "delete",

                                    {
                                        id: id
                                    },

                                    {
                                        success: (data) => {
                                            data = JSON.parse(data);
                                            Centauri.Notify(data.type, data.title, data.description);

                                            Centauri.Components.ModulesComponent({
                                                type: "load",
                                                module: "domains"
                                            });
                                        },

                                        error: (data) => {
                                            console.error(data);
                                        }
                                    }
                                );
                            }
                        }
                    );
                }
            }
        });
    }

    else if(module == "filelist") {
        $action = $("table#filelist .actions .action");

        $action.on("click", function() {
            $tr = $(this).parent().parent().parent().parent();

            Centauri.Components.PagesComponent.uid = $(this).attr("data-uid");
            var action = $(this).attr("data-action");

            var uid  = $.trim($("td[data-type='uid']", $tr).text());
                uid  = Centauri.strReplace(uid, "# ", "");
            var name = $.trim($("td[data-type='name']", $tr).text());
            var path = $.trim($("td[data-type='path']", $tr).text());

            if(action == "actions-trigger") {
                $(this).toggleClass("active");
            }

            if(action == "file-edit") {
                Centauri.fn.Modal(
                    Centauri.__trans.modules[Centauri.Module] + " - Editor",
                    "<div class='md-form'><input id='file_name' type='text' value='" + name + "' class='form-control' /><label class='active'>" + Centauri.__trans.global.label_title + "</label></div>",

                    {
                        id: "NO_ID_MODAL",
                        size: "xl",

                        close: {
                            label: "",
                            class: "danger fas fa-times"
                        },

                        save: {
                            label: "",
                            class: "success fas fa-save"
                        }
                    },

                    {
                        save() {
                            Centauri.fn.Ajax(
                                "File",
                                "edit",

                                {
                                    uid: uid,
                                    oldName: name,
                                    name: $("#modal #file_name").val()
                                },

                                {
                                    success: (data) => {
                                        data = JSON.parse(data);
                                        Centauri.Notify(data.type, data.title, data.description);

                                        Centauri.Components.ModulesComponent({
                                            type: "load",
                                            module: "filelist"
                                        });
                                    },

                                    error: (data) => {
                                        console.error(data);
                                    }
                                }
                            );
                        }
                    }
                );
            }

            if(action == "file-crop") {
                Centauri.fn.Modal(
                    Centauri.__trans.modules[Centauri.Module] + " - Editor",
                    "<div class='md-form'><input id='file_name' type='text' value='" + name + "' class='form-control' /><label class='active'>" + Centauri.__trans.global.label_title + "</label></div><img id='croppableimage' src='" + path + "' class='img-fluid' />",

                    {
                        id: "NO_ID_MODAL",
                        size: "xl",

                        close: {
                            label: "",
                            class: "danger fas fa-times"
                        },

                        save: {
                            label: "",
                            class: "success fas fa-save"
                        }
                    },

                    {
                        save() {
                            var fileData = Centauri.Helper.VariablesHelper.fileData;

                            var formData = new FormData();
                            formData.append("_method", "HEAD");
                            formData.append("image", fileData.blob);
                            formData.append("name", $("#modal #file_name").val());

                            $.ajax({
                                type: "POST",
                                url: Centauri.Utility.PathsUtility.root + Centauri.Utility.PathsUtility.centauri + Centauri.Utility.PathsUtility.ajax + "File/crop",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,

                                success: (data) => {
                                    Centauri.Notify("success", "Filelist - Crop", "Image '" + name + "' has been cropped");

                                    Centauri.Components.ModulesComponent({
                                        type: "load",
                                        module: "filelist"
                                    });
                                },

                                error: (data) => {
                                    console.error(data);
                                }
                            });
                        }
                    }
                );

                Centauri.Service.ImageCroppingService($("#modal #croppableimage"));
            }

            if(action == "file-show") {
                window.open(path, "_blank");
            }

            if(action == "file-delete") {
                Centauri.fn.Modal(
                    Centauri.__trans.modals.areyousure,
                    "Do you want to continue deleting this file?",

                    {
                        id: "areyousure_deletefile",

                        close: {
                            label: Centauri.__trans.modals.btn_cancel,
                            class: "warning"
                        },

                        save: {
                            label: Centauri.__trans.modals.btn_delete,
                            class: "danger"
                        }
                    },

                    {
                        save() {
                            Centauri.fn.Ajax(
                                "File",
                                "delete",

                                {
                                    uid: uid
                                },

                                {
                                    success: (data) => {
                                        data = JSON.parse(data);
                                        Centauri.Notify(data.type, data.title, data.description);

                                        Centauri.Components.ModulesComponent({
                                            type: "load",
                                            module: "filelist"
                                        });
                                    },

                                    error: (data) => {
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

    else if(module == "languages") {
        $action = $("table#languages .actions .action");

        $action.on("click", function() {
            $tr = $(this).parent().parent().parent();

            Centauri.Components.PagesComponent.uid = $(this).attr("data-uid");
            var action = $(this).attr("data-action");

            var title = $.trim($("td[data-type='title']", $tr).text());
            var langcode = $.trim($("td[data-type='lang_code']", $tr).text());
            var url = $.trim($("td[data-type='url']", $tr).text());
            var created_at = $.trim($("td[data-type='created_at']", $tr).text());
            var modified_at = $.trim($("td[data-type='updated_at']", $tr).text());

            if(action == "language-edit") {
                Centauri.Components.EditorComponent("show", {
                    id: "EditLanguage-" + Centauri.Components.PagesComponent.uid,
                    title: "Language-Editor - Edit",

                    form: [
                        {
                            id: "uid",
                            label: "UID",
                            type: "text",
                            value: Centauri.Components.PagesComponent.uid,
                            extraAttr: "disabled"
                        },

                        {
                            id: "title",
                            label: Centauri.__trans.global.label_title,
                            type: "text",
                            value: title,
                            required: true
                        },

                        {
                            id: "langcode",
                            label: "Lang-Code",
                            type: "text",
                            value: langcode,
                            required: true
                        },

                        {
                            id: "url",
                            label: "Slug",
                            type: "text",
                            value: url,
                            required: true
                        },

                        {
                            id: "created_at",
                            label: Centauri.__trans.global.label_createdat,
                            type: "text",
                            value: created_at,
                            extraAttr: "disabled"
                        },

                        {
                            id: "modified_at",
                            label: Centauri.__trans.global.label_modifiedat,
                            type: "text",
                            value: modified_at,
                            extraAttr: "disabled"
                        }
                    ],

                    callbacks: {
                        save: function(formData) {
                            Centauri.fn.Ajax(
                                "Language",
                                "editLanguage",

                                {
                                    uid: Centauri.Components.PagesComponent.uid,
                                    title: formData.title,
                                    slug: formData.url,
                                    langcode: formData.langcode
                                },

                                {
                                    success: function(data) {
                                        data = JSON.parse(data);
                                        Centauri.Notify(data.type, data.title, data.description);

                                        Centauri.Components.EditorComponent("close");

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

            if(action == "language-delete") {
                Centauri.fn.Modal(
                    // "Delete " + title + " language",
                    // "Are you sure to continue deleting the language '" + title + "' with all its bounded content?",
                    Centauri.strReplace(Centauri.__trans.modals.deleteLanguage_title, "{title}", title),
                    Centauri.strReplace(Centauri.__trans.modals.deleteLanguage_body, "{body}", title),

                    {
                        id: "areyousure_deletelanguage",

                        close: {
                            label: Centauri.__trans.modals.btn_cancel,
                            class: "warning"
                        },

                        save: {
                            label: Centauri.__trans.modals.btn_delete,
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

    else if(module == "notifications") {
        $action = $("table#notifications .actions .action");

        $action.on("click", function() {
            $tr = $(this).parent().parent().parent();

            Centauri.Components.PagesComponent.uid = $(this).attr("data-uid");

            Centauri.fn.Ajax(
                "Notification",
                "deleteByUid",

                {
                    uid: Centauri.Components.PagesComponent.uid
                },

                {
                    success: function(data) {
                        data = JSON.parse(data);
                        Centauri.Notify(data.type, data.title, data.description);

                        Centauri.Components.ModulesComponent({
                            type: "load",
                            module: "notifications"
                        });
                    },

                    error: function(data) {
                        console.error(data);
                    }
                }
            );
        });
    }
};
