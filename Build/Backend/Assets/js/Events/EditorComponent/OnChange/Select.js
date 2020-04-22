Centauri.Events.EditorComponent.Select.OnChange = function(select) {
    let dataID = $editor.attr("data-id");
    let id = $(select).attr("id");

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
                let slugs = $.trim($tr.find("td[data-type='url']").text());

                if(slugs != "/") {
                    slugs += "/";
                }

                $("form #url", $editor, $editor).focus();

                if(uid != parseInt($.trim($("table#pages tr:first-child td[data-type='uid']").text()))) {
                    if(slugs != "/") {
                        $("form #url", $editor).val(slugs + $("form #title", $editor).val());
                    } else {
                        $("form #url", $editor).val(slugs + $("form #title", $editor).val().toLowerCase());
                    }
                }

                // if(slugs != "/") {
                $("form #title", $editor, $editor).focus();
                // }
            }
        }
    }
};

Centauri.Events.EditorComponent.Select.OnChange.PrefillSlug = true;
