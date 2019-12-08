Centauri.Utility.UpdateHeadTags = function(tags) {
    $.each(tags, function(index, tag) {
        var key = tag[0];
        var value = tag[1];

        $("html head").find(key).html(value);
    });
};
