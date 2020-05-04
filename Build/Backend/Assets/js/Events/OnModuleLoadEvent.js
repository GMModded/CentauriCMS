Centauri.Events.OnModuleLoadEvent = function(module) {
    $("#dashboard #modules .module.active").removeClass("active");
    $("#dashboard #modules .module[data-module-id='" + module + "']").addClass("active");

    Centauri.Module = module;
    Centauri.Components.PagesComponent(module);

    var splittedTitle = $.trim($("title", $(document.head)).text()).split("»");
    var moduleName = Centauri.__trans.modules[Centauri.Module];
    if(Centauri.isUndefined(moduleName)) moduleName = "";
    var title = splittedTitle[0] + "» " + moduleName
    $("title", document.head).text(title);

    /**
     * Initialize a-tags turning into AJAX-calls
     */
    Centauri.Service.ATagAjaxService();

    /**
     * DAPLoader
     */
    if(Centauri.DAPLoader.historyPushState) {
        history.pushState({page: 1}, module, Centauri.Utility.PathsUtility.root + "centauri/" + module);
    }

    /**
     * Hamburger-Toggler
     */
    if(
        (
            Centauri.Helper.VariablesHelper.__BreakpointView == "sm"
        ||
            Centauri.Helper.VariablesHelper.__BreakpointView == "md"
        )
    &&
        $(".overlayer").attr("data-closer") == "DashboardView"
    ) {
        $(".hamburger").trigger("click");

        $(".overlayer").addClass("hidden");
        Centauri.Events.OnOverlayerHiddenEvent($(".overlayer").attr("data-closer"));
    }

    /**
     * Table Search-Filter
     */
    $("#content input#filter").on("keyup", function(e) {
        var value = $(this).val();

        if(value != "") {
            $("table tbody tr").css("display", "none");

            $("table tbody td").each(function() {
                var $td = $(this);

                var text = $.trim($td.text());

                if(Centauri.strContains(text, value)) {
                    $td.parent().css("display", "table-row");
                }
            });
        } else {
            $("table tbody tr").css("display", "table-row");
        }
    });

    /**
     * Refresh Button
     */
    $("#content > section button[data-button-type='refresh']").on("click", function() {
        Centauri.Components.ModulesComponent({
            type: "load",
            module: Centauri.Module
        });
    });

    /**
     * Modules
     */
    if(module == "dashboard") {
        let ctxL = document.getElementById("lineChart_frontendcalls").getContext('2d');
        let myLineChart = new Chart(ctxL, {
            type: "line",

            options: {
                responsive: true
            },

            data: {
                labels: [
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
                ],

                datasets: [
                    {
                        label: "Frontend Requests (including your IP)",
                        data: [
                            65, 59, 80, 81, 56, 55, 40, 80, 20, 33, 55, 77
                        ],

                        backgroundColor: [
                            "transparent",
                        ],

                        borderWidth: 2,
                        borderColor: [
                            "#f6c23e",
                        ]
                    },

                    {
                        label: "Frontend Requests (not including your IP)",
                        data: [
                            28, 48, 40, 19, 86, 27, 90, 11, 33, 22, 44, 55
                        ],

                        backgroundColor: [
                            "transparent",
                        ],

                        borderWidth: 2,
                        borderColor: [
                            "#4e73df",
                        ]
                    }
                ]
            }
        });
    }

    else if(module == "pages") {
        $("table#pages tr").on("dblclick", this, function() {
            $(".actions .action[data-action='page-edit']", $(this)).trigger("click");
        });

        $("#pagemodule_buttons button").each(function() {
            $button = $(this);

            $button.on("click", this, function() {
                let btnType = $(this).data("button-type");

                if(btnType == "create") {
                    Centauri.fn.Ajax(
                        "Page",
                        "getRootPages",

                        {},

                        {
                            success: function(data) {
                                data = JSON.parse(data);
                                let rootpages = data;

                                Centauri.fn.Ajax(
                                    "Page",
                                    "getLanguages",

                                    {},

                                    {
                                        success: function(data) {
                                            data = JSON.parse(data);
                                            let languages = data;

                                            if(languages.length == 0) {
                                                Centauri.Notify("primary", "No languages detected", "Please create a language in order to create (root)pages!", {
                                                    timeOut: 10000
                                                });

                                                Centauri.Components.ModulesComponent({
                                                    type: "load",
                                                    module: "languages"
                                                });
                                            } else {
                                                Centauri.fn.Ajax(
                                                    "BackendLayouts",
                                                    "findAll",

                                                    {},

                                                    {
                                                        success: (data) => {
                                                            data = JSON.parse(data);
                                                            let beLayouts = data;

                                                            Centauri.Components.EditorComponent("show", {
                                                                id: "CreateNewPage",
                                                                title: "Page-Editor - New",

                                                                form: [
                                                                    {
                                                                        id: "parent",
                                                                        type: "custom",
                                                                        custom: "select",

                                                                        data: {
                                                                            label: Centauri.__trans.EditorComponent.label_rootpage,
                                                                            options: rootpages
                                                                        }
                                                                    },

                                                                    {
                                                                        id: "language",
                                                                        type: "custom",
                                                                        custom: "select",
                                                                        extraAttr: "style='display: none!important;'",

                                                                        data: {
                                                                            label: Centauri.__trans.global.label_languages,
                                                                            options: languages
                                                                        }
                                                                    },

                                                                    {
                                                                        id: "title",
                                                                        type: "text",
                                                                        label: Centauri.__trans.global.label_title,
                                                                        required: true
                                                                    },

                                                                    {
                                                                        id: "url",
                                                                        type: "text",
                                                                        label: "URL",
                                                                        required: true
                                                                    },
/*
                                                                    {
                                                                        id: "page_type",
                                                                        type: "custom",
                                                                        custom: "radio",
                                                                        additionalFieldClasses: "newpage-pagetype",

                                                                        data: {
                                                                            callbacks: {
                                                                                onChange: "Centauri.Events.EditorComponent.Radio.OnClick(this)"
                                                                            },

                                                                            items: [
                                                                                {
                                                                                    id: "rootpage",
                                                                                    isChecked: true,
                                                                                    label: Centauri.__trans.EditorComponent.label_rootpage + "?"
                                                                                },

                                                                                {
                                                                                    id: "subpage",
                                                                                    label: Centauri.__trans.EditorComponent.label_subpage + "?"
                                                                                }
                                                                            ],
                                                                        }
                                                                    },
*/
                                                                    {
                                                                        id: "is_rootpage",
                                                                        type: "custom",
                                                                        custom: "switch",

                                                                        data: {
                                                                            label: Centauri.__trans.EditorComponent.label_rootpage + "?",
                                                                            isChecked: false,
                                                                            onClick: "Centauri.Events.EditorComponent.Checkbox.OnClick(this)"
                                                                        }
                                                                    },

                                                                    {
                                                                        id: "be_layout",
                                                                        type: "custom",
                                                                        custom: "select",

                                                                        data: {
                                                                            selectedOptionValue: "default",
                                                                            label: "Backend-Layout",
                                                                            options: beLayouts
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
                                                                                url: $("#url", $editor).val(),
                                                                                belayout: $("#be_layout").val()
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

                                                        error: (data) => {
                                                            console.error(data);
                                                        }
                                                    }
                                                );
                                            }
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

    else if(module == "domains") {
        $("#domainsmodule_buttons button").each(function() {
            $button = $(this);

            $button.on("click", this, function() {
                var btnType = $(this).data("button-type");

                if(btnType == "create") {
                    Centauri.fn.Ajax(
                        "Domains",
                        "showModal",

                        {},

                        {
                            success: function(data) {
                                Centauri.fn.Modal(
                                    "New Domain",

                                    data,

                                    {
                                        id: "new_domain",                
                                        size: "xl",
                                        closeOnSave: false,

                                        close: {
                                            label: Centauri.__trans.modals.btn_cancel
                                        },

                                        save: {
                                            label: Centauri.__trans.modals.btn_create
                                        }
                                    },

                                    {
                                        save: function() {
                                            Centauri.fn.Modal.close();

                                            Centauri.fn.Ajax(
                                                "Domains",
                                                "create",

                                                {
                                                    id: $("#modal #id").val(),
                                                    domain: $("#modal #domain").val(),
                                                    rootpageuid: $("#modal #rootpageuid").val()
                                                },

                                                {
                                                    success: function(data) {
                                                        data = JSON.parse(data);
                                                        Centauri.Notify(data.type, data.title, data.description);

                                                        Centauri.Components.ModulesComponent({
                                                            type: "load",
                                                            module: Centauri.Module
                                                        });
                                                    },

                                                    error: function(data) {
                                                        console.error(data);
                                                        $(".overlayer").addClass("hidden");
                                                    }
                                                }
                                            );
                                        }
                                    }
                                );

                                Centauri.Modal.ModelModal();

                                Centauri.Service.CKEditorInitService();
                            },

                            error: function(data) {
                                console.error(data);
                            }
                        }
                    );
                }
            });
        });
    }

    else if(module == "filelist") {
        $("#filelistmodule_buttons button").each(function() {
            $button = $(this);

            $button.on("click", this, function() {
                var btnType = $(this).data("button-type");

                if(btnType == "upload") {
                    // $("input", $(this))[0].trigger("click");
                }
            });
        });
    }

    else if(module == "languages") {
        $("table#languages tr").on("dblclick", this, function() {
            $(".actions .action[data-action='language-edit']", $(this)).trigger("click");
        });

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
                                label: Centauri.__trans.global.label_title,
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
                                Centauri.Helper.VariablesHelper.__closeAjax = true;

                                Centauri.fn.Ajax(
                                    "Language",
                                    "newLanguage",

                                    {
                                        data: data
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
            });
        });
    }

    else if(module == "extensions") {
        $("#extensionsmodule_buttons button").each(function() {
            $button = $(this);

            $button.on("click", this, function() {
                var btnType = $(this).data("button-type");
            });
        });
    }

    else if(module == "notifications") {}

    else if(module == "models") {
        $("#modelsmodule_buttons button").each(function() {
            $button = $(this);

            $button.on("click", this, function() {
                var btnType = $(this).data("button-type");

                if(btnType == "create") {
                    Centauri.fn.Ajax(
                        "Models",
                        "getModelConfigs",

                        {},

                        {
                            success: function(data) {
                                Centauri.fn.Modal(
                                    "New Model",

                                    data,

                                    {
                                        id: "new_model",
                                        size: "xl",
                                        closeOnSave: false,

                                        close: {
                                            label: Centauri.__trans.modals.btn_cancel
                                        },

                                        save: {
                                            label: Centauri.__trans.modals.btn_create
                                        }
                                    },

                                    {
                                        ready: () => {
                                            Centauri.View.ContentElementsView();
                                        },

                                        save: function() {
                                            if(Centauri.isNull(Centauri.Helper.ModalHelper.Element)) {
                                                toastr["error"]("Models Error", "Please select any model in order to create one!");
                                                return;
                                            }

                                            Centauri.fn.Modal.close();
                                            let datas = Centauri.Helper.FieldsHelper($(Centauri.Helper.ModalHelper.Element), ".bottom");

                                            Centauri.fn.Ajax(
                                                "Models",
                                                "newModel",

                                                {
                                                    model: Centauri.Helper.ModalHelper.Element.data("model"),
                                                    datas: JSON.stringify(datas)
                                                },

                                                {
                                                    success: function(data) {
                                                        data = JSON.parse(data);
                                                        Centauri.Notify(data.type, data.title, data.description);

                                                        Centauri.Components.ModulesComponent({
                                                            type: "load",
                                                            module: Centauri.Module
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

                                Centauri.Modal.ModelModal();

                                Centauri.Service.CKEditorInitService();
                            },

                            error: function(data) {
                                console.error(data);
                            }
                        }
                    );
                }
            });
        });
    }


    else {
        console.warn("Centauri.Events.OnModuleLoadEvent: Module '" + module + "' has not been registered with Centauri.Events.OnModuleLoadEvent");
    }
};
