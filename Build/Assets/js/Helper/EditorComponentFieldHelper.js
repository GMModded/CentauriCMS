Centauri.Helper.EditorComponentFieldHelper = () => {
    let datas = [];

    let selectors = [
        $(".bottom .md-form > input", $editor),
        $(".bottom .field.switch > label > input", $editor),
        $(".bottom .md-form > .md-textarea", $editor),
        $(".bottom .md-form > .mdb-select", $editor)
    ];

    selectors.forEach(selector => {
        $(selector).each(function() {
            let $this = $(this);

            if(Centauri.isUndefined($this.attr("disabled")) && Centauri.isUndefined($this.attr("readonly"))) {
                let id = $this.attr("id");

                if(Centauri.isNotUndefined(id)) {
                    let value = $this.val();

                    if(Centauri.isNotUndefined($this.attr("type"))) {
                        if($this.attr("type") == "checkbox") {
                            value = $this.prop("checked");
                        }
                    }

                    datas[id] = value;
                }
            }
        });
    });

    var nDatas = $.extend(nDatas, datas);
    return JSON.stringify(nDatas);
};
