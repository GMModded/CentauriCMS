Centauri.Events.OnModuleLoadEvent.Languages.RegisterActions = () => {
    let $action = $("table#languages .actions .action");

    $action.on("click", this, function() {
        let $tr = $(this).parent().parent().parent();

        Centauri.Components.PagesComponent.uid = $(this).attr("data-uid");
        let action = $(this).attr("data-action");

        let title = $.trim($("td[data-type='title']", $tr).text());
        let langcode = $.trim($("td[data-type='lang_code']", $tr).text());
        let url = $.trim($("td[data-type='url']", $tr).text());
        let created_at = $.trim($("td[data-type='created_at']", $tr).text());
        let modified_at = $.trim($("td[data-type='updated_at']", $tr).text());

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
                        label: Centauri__trans.global.label_title,
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
                        label: Centauri__trans.global.label_createdat,
                        type: "text",
                        value: created_at,
                        extraAttr: "disabled"
                    },

                    {
                        id: "modified_at",
                        label: Centauri__trans.global.label_modifiedat,
                        type: "text",
                        value: modified_at,
                        extraAttr: "disabled"
                    }
                ],

                callbacks: {
                    save: (formData) => {
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
                                success: (data) => {
                                    data = JSON.parse(data);
                                    Centauri.Notify(data);

                                    Centauri.Components.EditorComponent("close");

                                    Centauri.Components.ModulesComponent({
                                        type: "load",
                                        module: "languages"
                                    });
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
                Centauri.strReplace(Centauri__trans.modals.deleteLanguage_title, "{title}", title),
                Centauri.strReplace(Centauri__trans.modals.deleteLanguage_body, "{body}", title),

                {
                    id: "areyousure_deletelanguage",

                    close: {
                        label: Centauri__trans.modals.btn_cancel,
                        class: "warning"
                    },

                    save: {
                        label: Centauri__trans.modals.btn_delete,
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
                                success: (data) => {
                                    data = JSON.parse(data);
                                    Centauri.Notify(data);

                                    Centauri.Components.ModulesComponent({
                                        type: "load",
                                        module: "languages"
                                    });
                                }
                            }
                        );
                    }
                }
            );
        }
    });
};
