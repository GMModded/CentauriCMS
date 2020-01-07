Centauri.Events.EditorComponent.Input.OnKeyDown = function(input, e) {
    var dataID = $editor.attr("data-id");
    var id = $(input).attr("id");

    var value = $("form #" + id, $editor).val();

    if(dataID == "CreateNewPage") {
        if(id == "title") {
            if(e.which == 9 && value.length >= 2) {
                var slugs = value.toLowerCase();
                    slugs = slugs[0] + slugs[1];

                $("form #langcode", $editor).focus();
                $("form #langcode", $editor).val(slugs + "-" + slugs.toUpperCase());

                $("form #slug", $editor).focus();
                $("form #slug", $editor).val(slugs);

                $("form #langcode", $editor).focus();
            }
        }

        if(id == "langcode") {
            if(e.which == 9 && value.length >= 2) {
                var slugs = $("form #langcode", $editor).val().split("-")[0].toLowerCase();

                $("form #slug", $editor).focus();
                $("form #slug", $editor).val(slugs);

                $("form #slug", $editor).focus();
            }
        }
    }
};
