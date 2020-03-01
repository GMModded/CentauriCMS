Centauri.Helper.FieldsHelper = function(element, parentSelector) {
    var datas = [];

    $(parentSelector + " .md-form > input", $(element)).each(function() {
        var id = $(this).attr("data-id");

        if(Centauri.isNotUndefined(id)) {
            var val = $(this).val();

            if($(this).hasClass("image-input")) {
                datas.push({
                    type: "NORMAL",
                    id: id,
                    value: parseInt(val),
                    inlineparent: $(this).parent().parent().parent().parent().data("type-parent"),
                    inline: $(this).parent().parent().parent().parent().data("type"),
                    uid: $(this).parent().parent().parent().data("uid")
                });
            } else {
                datas.push({
                    type: "NORMAL",
                    id: id,
                    value: val,
                    inlineparent: $(this).parent().parent().parent().parent().data("type-parent"),
                    inline: ($(this).data("inline-record") == 1 ? $(this).parent().parent().parent().parent().data("type") : false),
                    uid: ($(this).data("inline-record") == 1 ? $(this).parent().parent().parent().data("uid") : $(this).parent().parent().parent().parent().parent().data("uid"))
                });
            }
        }
    });

    $(parentSelector + " .md-form > .md-textarea", $(element)).each(function() {
        var id = $(this).attr("data-id");

        if(Centauri.isNotUndefined(id)) {
            var val = $(this).html();

            datas.push({
                type: "NORMAL",
                id: id,
                value: val,
                inlineparent: $(this).parent().parent().parent().parent().data("type-parent"),
                inline: ($(this).data("inline-record") == 1 ? $(this).parent().parent().parent().parent().data("type") : false),
                uid: ($(this).data("inline-record") == 1 ? $(this).parent().parent().parent().data("uid") : $(this).parent().parent().parent().data("uid"))
            });
        }
    });

    $(parentSelector + " select", $(element)).each(function() {
        var id = $(this).attr("data-id");

        if(Centauri.isNotUndefined(id)) {
            var val = $(this).val();

            datas.push({
                type: "NORMAL",
                id: id,
                value: val,
                inlineparent: $(this).parent().parent().parent().parent().data("type-parent"),
                inline: ($(this).data("inline-record") == 1 ? $(this).parent().parent().parent().parent().data("type") : false),
                uid: ($(this).data("inline-record") == 1 ? $(this).parent().parent().parent().data("uid") : $(this).parent().parent().parent().parent().parent().data("uid"))
            });
        }
    });

    /**
     * @todo
     * 
     * !!! Image selector and push to datas-variable for saving into DB !!!
     */

    // Inline-Records "connection"
    $(parentSelector + " .md-form > .accordions.inline-records", $(element)).each(function(aindex, parentAccordion) {
        $(".accordion", $(parentAccordion)).each(function(bindex, accordion) {
            Centauri.Helper.FieldsHelper($(accordion), ".bottom");
        });
    });

    console.table(datas);

    return datas;
};
