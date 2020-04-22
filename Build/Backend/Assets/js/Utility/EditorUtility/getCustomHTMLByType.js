Centauri.Utility.EditorUtility.getCustomHTMLByType = function(inputObj) {
    let html = "";
    let type = inputObj.custom;
    let data = inputObj.data;

    let additionalFieldClasses = "";

    if(type == "select") {
        let options = "";

        let labelHTML = "<label class='mdb-main-label' for='" + inputObj.id + "'>" + data.label + "</label>";
        html = "<select id='" + inputObj.id + "' class='mdb-select select2 colorful-select dropdown-primary md-form' searchable='" + Centauri.__trans.global.searchhere + "' " + (Centauri.isNotUndefined(data.required) ? (data.required ? "required" : "") : "required") + ">|</select>";

        if(Centauri.isNotUndefined(data.label)) {
            html.split("|").join("<option value='' disabled selected>" + data.label + "</option>|");
            html = html + labelHTML;
        }

        if(Centauri.isNotUndefined(data.options)) {
            $.each(data.options, function(index, optionObj) {
                if(Centauri.isNotUndefined(data.selectedOptionValue)) {
                    if(data.selectedOptionValue == optionObj.value) {
                        options += "<option value='" + optionObj.value + "' selected>" + optionObj.name;
                    } else {
                        options += "<option value='" + optionObj.value + "'>" + optionObj.name;
                    }
                } else {
                    options += "<option value='" + optionObj.value + "'>" + optionObj.name;
                }
            });
        }

        html = html.split("|").join(options);
    }

    if(type == "image") {
        html = "<label class='d-block m-0'>" + data.label + "</label><img src='" + data.src + "' class='img-fluid' style='width: 30px;' />";
    }

    if(type == "checkbox") {
        let checked = "";

        if(Centauri.isNotUndefined(data.isChecked)) {
            if(data.isChecked) {
                checked = " checked";
            }
        }

        additionalFieldClasses = " custom-control custom-checkbox";
        html = "<input id='" + inputObj.id + "' class='custom-control-input' type='checkbox'" + checked + " /><label class='custom-control-label d-block m-0' for='" + inputObj.id + "'>" + data.label + "</label>";
    }

    if(type == "switch") {
        let checked = "";
        let onClick = "";

        if(Centauri.isNotUndefined(data.isChecked)) {
            if(data.isChecked) {
                checked = " checked";
            }
        }

        if(Centauri.isNotUndefined(data.onClick)) {
            let onClick = " onclick='" + data.onClick + "'";
        }

        additionalFieldClasses = " switch";
        html = "<label><input type='checkbox'" + checked + " id='" + inputObj.id + "'" + onClick + " /><span class='ml-1 lever'></span>" + data.label + "</label>";
    }

    if(type == "radio") {
        let items = data.items;

        additionalFieldClasses = " radio";

        if(Centauri.isNotUndefined(inputObj.additionalFieldClasses)) {
            additionalFieldClasses += " " + inputObj.additionalFieldClasses;
        }

        items.forEach(item => {
            html += "<div class='form-check'><input type='radio' class='form-check-input' name='" + inputObj.id + "' id='" + item.id + "'" + (item.isChecked ? " checked" : "") + "><label class='form-check-label' for='" + item.id + "'>" + item.label + "</label></div>";
        });
    }

    return "<div class='field" + additionalFieldClasses + "'" + (Centauri.isNotUndefined(inputObj.extraAttr) ? " " + inputObj.extraAttr : "") + ">" + html + "</div>";
};
