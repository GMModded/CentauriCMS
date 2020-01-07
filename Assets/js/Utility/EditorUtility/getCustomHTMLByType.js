Centauri.Utility.EditorUtility.getCustomHTMLByType = function(inputObj) {
    var html = "";
    var type = inputObj.custom;
    var data = inputObj.data;

    var additionalFieldClasses = "";

    if(type == "select") {
        var options = "";

        var labelHTML = "<label class='mdb-main-label' for='" + inputObj.id + "'>" + data.label + "</label>";
        html = "<select id='" + inputObj.id + "' class='mdb-select select2 colorful-select dropdown-primary md-form' searchable='" + Centauri.__trans.global.searchhere + "' required>|</select>";

        if(Centauri.isNotUndefined(data.label)) {
            html.split("|").join("<option value='' disabled selected>" + data.label + "</option>|");
            html = html + labelHTML;
        }

        if(Centauri.isNotUndefined(data.options)) {
            $.each(data.options, function(index, optionObj) {
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
        html = "<input id='" + inputObj.id + "' class='custom-control-input' type='checkbox'" + checked + " /><label class='custom-control-label d-block m-0' for='" + inputObj.id + "'>" + data.label + "</label>";
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
        html = "<label><input type='checkbox'" + checked + " id='" + inputObj.id + "'" + onClick + " /><span class='ml-1 lever'></span>" + data.label + "</label>";
    }

    return "<div class='field" + additionalFieldClasses + "'" + (Centauri.isNotUndefined(inputObj.extraAttr) ? " " + inputObj.extraAttr : "") + ">" + html + "</div>";
};
