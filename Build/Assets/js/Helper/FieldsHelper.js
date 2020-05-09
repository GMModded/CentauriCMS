Centauri.Helper.FieldsHelper = function(element, parentSelector, returnAsJson = true) {
    let datas = [];

    if(
        $(element).is(Centauri.Helper.ModalHelper.Element) ||
        $(element).is($(".accordion.active"))
    ) {
        datas = Centauri.Helper.FieldsHelper.findDatasBySelectors([
            $(parentSelector + " .md-form > input", $(element)),
            $(parentSelector + " .md-form > .md-textarea", $(element)),
            $(parentSelector + " .md-form > select", $(element))
        ]);
    } else {
        datas = Centauri.Helper.FieldsHelper.findDatasBySelectors([
            $(parentSelector + " .md-form > input"),
            $(parentSelector + " .md-form > .md-textarea"),
            $(parentSelector + " .md-form > select")
        ]);
    }

    if(returnAsJson) {
        let tempArr = [];

        Object.keys(datas).forEach((data) => {
            tempArr.push(datas[data]);
        });

        datas = JSON.stringify(tempArr);
    }

    return datas;
};

Centauri.Helper.FieldsHelper.findDatasBySelectors = (selectors) => {
    let datas = [];

    selectors.forEach(selector => {
        $(selector).each(function() {
            let id = $(this).data("id");

            if(Centauri.isNotUndefined(id)) {
                let val = $(this).val();
                let uid = $(this).data("uid");
                let isIR = $(this).data("inline-record");
                let table = "elements";
                let parentuid = null;

                /**
                 * Handling for specific elements (by checking their classes) the correct way of fetching its current/changed value
                 */
                if($(this).hasClass("md-textarea")) {
                    val = $(this).html();
                }

                if($(this).hasClass("image-input")) {
                    if(val == "") {
                        val = null;
                    }
                }

                /**
                 * In case the User creates a new Element using the Modal we set uid as "NEW" for the datas-Array
                 */
                if($(selector).is(Centauri.Helper.ModalHelper.Element)) {
                    uid = "NEW";
                }

                /**
                 * If the current found field is an Inline-Record we set its table in the datas-Array to the parents' data-type-Attribute
                 */
                if(isIR) {
                    table = $(this).parents(".accordions.inline-records").data("type");
                    parentuid = $(this).parents(".accordions.inline-records").parents(".accordion").data("uid");
                }

                /**
                 * datas-Array logic.
                 */
                if(Centauri.isUndefined(datas[table])) {
                    datas[table] = {};
                }
                if(Centauri.isUndefined(datas[table][uid])) {
                    datas[table][uid] = {};
                }
                datas[table][uid][id] = {
                    value: val
                };
            }
        });
    });

    return datas;
};
