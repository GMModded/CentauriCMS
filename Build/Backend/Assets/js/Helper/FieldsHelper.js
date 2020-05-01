Centauri.Helper.FieldsHelper = function(element, parentSelector, calledBy = "") {
    let datas = [];

    if($(element).is(Centauri.Helper.ModalHelper.Element)) {
        datas = Centauri.Helper.FieldsHelper.findDatasBySelectors([
            $(parentSelector + " .md-form > input", $(element)),
            $(parentSelector + " .md-form > .md-textarea", $(element))
        ]);
    } else{
        datas = Centauri.Helper.FieldsHelper.findDatasBySelectors([
            $(parentSelector + " .md-form > input"),
            $(parentSelector + " .md-form > .md-textarea")
        ]);
    }

    /**
     * Inline-Records "connection"
     * Inline type
     */
    // if(!calledByIR) {
    //     $(parentSelector + " .accordion", $(element)).each(function(aindex, accordion) {
    //         datas.push(Centauri.Helper.FieldsHelper($(accordion), ".bottom", true));
    //     });
    // }

    if(Centauri.isDebugging) {
        console.table(datas);
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

                /**
                 * Handling for specific elements (by checking their classes) the correct way of fetching its current/changed value
                 */
                if($(this).hasClass("md-textarea")) {
                    val = $(this).html();
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
                datas[table][uid][id] = val;
            }
        });
    });

    return datas;
};
