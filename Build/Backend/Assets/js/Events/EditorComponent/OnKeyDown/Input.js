Centauri.Events.EditorComponent.Input.OnKeyDown = function(input, e) {
    let dataID = $editor.attr("data-id");
    let id = $(input).attr("id");

    let value = $("form #" + id, $editor).val();

    console.log(dataID);

    if(dataID == "CreateNewPage") {
        if(id == "title") {
            if(e.which == 9 && value.length >= 2) {
                let slugs = value.toLowerCase();
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
                let slugs = $("form #langcode", $editor).val().split("-")[0].toLowerCase();

                $("form #slug", $editor).focus();
                $("form #slug", $editor).val(slugs);

                $("form #slug", $editor).focus();
            }
        }
    }
};
