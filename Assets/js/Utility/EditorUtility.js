Centauri.Utility.EditorUtility = {};

Centauri.Utility.EditorUtility.getCustomHTMLByType = function(inputObj) {
    var html = "";
    var type = inputObj.custom;
    var data = inputObj.data;

    var additionalFieldClasses = "";

    if(type == "select") {
        var options = "";

        // html = "<div class='centauri-select' id='" + inputObj.id + "'>|</div>";
        html = "<select style='display:block!important;' class='form-control' id='" + inputObj.id + "'>|</select>";

        if(Centauri.isNotUndefined(data.options)) {
            $.each(data.options, function(index, optionObj) {
                // options += "<div class='item' data-value='" + optionObj.value + "'>" + optionObj.name + "</div>";
                options += "<option value='" + optionObj.value + "'>" + optionObj.name;
            });
        }

        html = html.split("|").join(options);
    }

    if(type == "image") {
        html = "<label class='d-block m-0'>" + data.label + "</label><img src='" + data.src + "' class='img-fluid' style='width: 30px;' />";
    }

    if(type == "checkbox") {
        var checked = "";

        if(Centauri.isNotUndefined(data.isChecked)) {
            if(data.isChecked) {
                checked = " checked";
            }
        }

        additionalFieldClasses = " custom-control custom-checkbox";
        html = "<input id='input-checkbox-" + inputObj.id + "' class='custom-control-input' type='checkbox'" + checked + " /><label class='custom-control-label d-block m-0' for='input-checkbox-" + inputObj.id + "'>" + data.label + "</label>";
    }

    if(type == "switch") {
        var checked = "";
        var onClick = "";

        if(Centauri.isNotUndefined(data.isChecked)) {
            if(data.isChecked) {
                checked = " checked";
            }
        }

        if(Centauri.isNotUndefined(data.onClick)) {
            var onClick = " onclick='" + data.onClick + "'";
        }

        additionalFieldClasses = " switch";
        html = "<label><input type='checkbox'" + checked + " id='" + inputObj.id + "' /><span class='ml-1 lever'></span>" + data.label + "</label>";
    }

    return "<div class='field" + additionalFieldClasses + "'>" + html + "</div>";
};
