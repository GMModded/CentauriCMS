Centauri.Helper.FieldsHelper = function(element, parentSelector) {
    var datas = [];

    var elementUid = $(element).data("uid");

    $(parentSelector + " .md-form > input:not(.d-none):not([data-inlinerecord='true'])", $(element)).each(function() {
        var id = $(this).attr("id");

        if(Centauri.isNotUndefined(id)) {
            var val = $(this).val();

            datas.push({
                type: "NORMAL",
                id: id,
                value: val
            });
        }
    });

    $(parentSelector + " .md-form > div.ck-editor", $(element)).each(function() {
        var id = $(this).parent().find("textarea").attr("id");

        if(Centauri.isNotUndefined(id)) {
            var val = $(".ck-content", $(this)).html();

            datas.push({
                type: "NORMAL",
                id: id,
                value: val
            });
        }
    });

    $(parentSelector + " select", $(element)).each(function() {
        var id = $(this).attr("id");

        if(Centauri.isNotUndefined(id)) {
            var val = $(this).val();

            datas.push({
                type: "NORMAL",
                id: id,
                value: val
            });
        }
    });

    // Inline-Records "connection"
    $(parentSelector + " .md-form > .accordions", $(element)).each(function() {
        var dataType = $(this).data("type");

        $(".accordion", $(this)).each(function() {
            var $accordion = $(this);
            var uid = $accordion.data("uid");

            $("input[data-inlinerecord='true']", $accordion).each(function() {
                var $inlineRecord = $(this);
                var id = $inlineRecord.attr("id");

                if(Centauri.isNotUndefined(id)) {
                    var val = $inlineRecord.val();

                    datas.push({
                        type: "INLINE",
                        dataType: dataType,
                        id: id,
                        value: val,
                        elementUid: elementUid,
                        inlineUid: uid
                    });
                }
            });
        });
    });

    console.table(datas);

    return datas;
};
