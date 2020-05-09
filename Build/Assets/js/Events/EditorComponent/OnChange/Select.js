Centauri.Events.EditorComponent.Select.OnChange = function(select) {
    let dataID = $editor.attr("data-id");

    let id = $(select).attr("id");
    let selDataID = $(select).data("id");

    let required = $(select).attr("required");
    let value = $(select).val();
    let option = $(select).find("option[value='" + value + "']");

    if(Centauri.isNotUndefined(required)) {
        $(select).parent().find("input").removeClass("error");
    }

    if(
        Centauri.strContains(dataID, "TranslatePage-")
    ||
        dataID == "CreateNewPage"
    ) {
        if(Centauri.Events.EditorComponent.Select.OnChange.PrefillSlug) {
            if(id == "language") {
                let slugs = $.trim($(option).text()).toLowerCase();
                slugs = slugs[0] + slugs[1];

                $("form #url", $editor).focus();
                $("form #url", $editor).val(slugs);
            }
        }
    }

    if(dataID == "CreateNewPage") {
        if(Centauri.Events.EditorComponent.Select.OnChange.PrefillSlug) {
            let uid = "";
            let $tr = null;

            $("table#pages td[data-type='uid']").each(function() {
                let nUid = $.trim($(this).text());
                if(nUid[2] == value) {
                    uid = parseInt(nUid[2]);
                    $tr = $(this).parent();
                }
            });

            if(Centauri.isNotNull($tr) && Centauri.elExists($tr) && Centauri.isNotUndefined($tr)) {
                // let slugs = $.trim($tr.find("td[data-type='url']").text());
                let slugs = "/";

                // if(slugs != "/") {
                //     slugs += "/";
                // }

                // $("form #url", $editor, $editor).focus();

                // if(uid != parseInt($.trim($("table#pages tr:first-child td[data-type='uid']").text()))) {
                //     if(slugs != "/") {
                //         $("form #url", $editor).val(slugs + $("form #title", $editor).val());
                //     } else {
                //         $("form #url", $editor).val(slugs + $("form #title", $editor).val().toLowerCase());
                //     }
                // }

                $("form #title", $editor, $editor).focus();
            }
        }
    }

    if(selDataID == "grid") {
        Centauri.fn.Modal(
            "Refresh required",
            "Changing the type of this Grid requires to update the element",

            {
                id: "refreshrequired_gridselect",

                close: {
                    label: Centauri.__trans.modals.btn_cancel,
                    class: "warning"
                },

                save: {
                    label: "Refresh",
                    class: "info"
                }
            },

            {
                cancel() {
                    $(select).val($("option[selected]:not(:disabled)", select).attr("value"));
                },

                save() {
                    let datas = Centauri.Helper.FieldsHelper($(".data"), ".content-element.active");

                    let tableInfo = {};
                    let i = 0;

                    Object.keys(JSON.parse(datas)[0]).forEach((data) => {
                        tableInfo[i] = JSON.parse(datas)[0][data];
                        i++;
                    });

                    Centauri.fn.Ajax(
                        "ContentElements",
                        "saveElementByUid",

                        {
                            uid: $contentelement.data("uid"),
                            datas: datas,
                            tableInfo: tableInfo
                        },

                        {
                            success: (data) => {
                                Centauri.Notify("primary", "Element updated", "This element has been updated");
                            }
                        }
                    );

                    Centauri.Helper.FindFieldsByUidHelper($contentelement, $(".edit", $contentelement));
                }
            }
        );
    }
};

Centauri.Events.EditorComponent.Select.OnChange.PrefillSlug = true;
