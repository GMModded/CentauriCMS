Centauri.Events.EditorComponent.Select.OnChange = function(select) {
    var dataID = $editor.attr("data-id");
    var id = $(select).attr("id");

    var required = $(select).attr("required");
    var value = $(select).val();
    var option = $(select).find("option[value='" + value + "']");

    if(Centauri.isNotUndefined(required)) {
        $(select).parent().find("input").removeClass("error");
    }

    if(
        Centauri.stringContains(dataID, "TranslatePage-")
    ||
        dataID == "CreateNewPage"
    ) {
        if(Centauri.Events.EditorComponent.Select.OnChange.PrefillSlug) {
            if(id == "language") {
                var slugs = $.trim($(option).text()).toLowerCase();
                slugs = slugs[0] + slugs[1];
    
                $("form #" + dataID + "_url", $editor).focus();
                $("form #" + dataID + "_url", $editor).val(slugs);
            }
        }
    }

    if(dataID == "CreateNewPage") {
        if(Centauri.Events.EditorComponent.Select.OnChange.PrefillSlug) {
            var uid = "";
            var $tr = null;

            $("table#pages td[data-type='uid']").each(function() {
                var nUid = $.trim($(this).text());
                if(nUid[2] == value) {
                    uid = parseInt(nUid[2]);
                    $tr = $(this).parent();
                }
            });

            if(Centauri.isNotNull($tr) && Centauri.elExists($tr) && Centauri.isNotUndefined($tr)) {
                var slugs = $.trim($tr.find("td[data-type='url']").text());
                if(slugs != "/") {
                    slugs += "/";
                }

                $("form #" + dataID + "_url", $editor, $editor).focus();

                if(uid != parseInt($.trim($("table#pages tr:first-child td[data-type='uid']").text()))) {
                    $("form #" + dataID + "_url", $editor).val(slugs);
                }

                if(slugs != "/") {
                    $("form #" + dataID + "_title", $editor, $editor).focus();
                }
            }
        }
    }
};

Centauri.Events.EditorComponent.Select.OnChange.PrefillSlug = true;
