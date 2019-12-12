Centauri.Utility.EditorUtility.Validator = function() {
    $form = $("form", $editor);

    $("input", $form).on("focusout", function() {
        var required = $(this).attr("required");

        if(Centauri.isNotUndefined(required)) {
            var value = $(this).val();

            if(value == "") {
                $(this).addClass("error");
            }
        }
    });

    $("input", $form).on("keyup", function() {
        var required = $(this).attr("required");

        if(Centauri.isNotUndefined(required)) {
            var value = $(this).val();

            if($(this).hasClass("error")) {
                if(value != "") {
                    $(this).removeClass("error");
                }
            } else {
                if(value == "") {
                    $(this).addClass("error");
                }
            }
        }
    });
};
