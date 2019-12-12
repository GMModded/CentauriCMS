Centauri.Events.EditorComponent.Select.OnChange = function(select) {
    var dataID = $editor.attr("data-id");
    var id = $(select).attr("id");

    var required = $(select).attr("required");
    var value = $(select).val();
    var option = $(select).find("option[value='" + value + "']");

    if(Centauri.isNotUndefined(required)) {
        $(select).parent().find("input").removeClass("error");
    }

    if(Centauri.stringContains(dataID, "TranslatePage-")) {
        if(id == "language") {
            var slugs = $.trim($(option).text()).toLowerCase();
            slugs = slugs[0] + slugs[1];

            $("form #" + dataID + "_url", $editor).val(slugs);
        }
    }
};
