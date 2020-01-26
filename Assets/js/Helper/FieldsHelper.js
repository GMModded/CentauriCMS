Centauri.Helper.FieldsHelper = function(element, parentSelector) {
    var datas = [];

    console.log(element, $(element));
    var elementUid = $(element).data("uid");

    $(parentSelector + " .md-form > input:not(.d-none):not([data-inlinerecord='true'])", $(element)).each(function() {
        var id = $(this).attr("data-id");

        if(Centauri.isNotUndefined(id)) {
            var val = $(this).val();

            datas.push({
                type: "NORMAL",
                id: id,
                value: val
            });
        }
    });

    $(parentSelector + " .md-form > .md-textarea", $(element)).each(function() {
        var id = $(this).attr("data-id");

        if(Centauri.isNotUndefined(id)) {
            var val = $(this).html();

            datas.push({
                type: "NORMAL",
                id: id,
                value: val
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
                value: val
            });
        }
    });

    // Inline-Records "connection"
    $(parentSelector + " .md-form > .accordions.inline-records", $(element)).each(function() {
        var dataType = $(this).data("type");

        $(".accordion", $(this)).each(function() {
            var $accordion = $(this);
            var uid = $accordion.data("uid");

            /*
             * Code for Inline-Record related data (e.g. title, link of an inline-record etc)
             * 

             $("input[data-inlinerecord='true']", $accordion).each(function() {
                var $inlineRecord = $(this);
                var id = $inlineRecord.attr("data-id");

                if(Centauri.isNotUndefined(id)) {
                    var val = $inlineRecord.val();
                }
            });
            */

            datas.push({
                type: "INLINE",
                dataType: dataType,
                value: uid
            });
        });
    });

    console.table(datas);

    return datas;
};
