Centauri.Events.EditorComponent.Checkbox.OnClick = function(element) {
    var id = $(element).attr("id");
    var checked = $(element).prop("checked");

    if(id == "is_rootpage") {
        if(checked) {
            $("#parent", $editor).parent().parent().hide();
            $("#language", $editor).parent().parent().attr("style", "display: block!important;");
        } else {
            $("#language", $editor).parent().parent().hide();
            $("#parent", $editor).parent().parent().attr("style", "display: block!important;");
        }
    }
};
