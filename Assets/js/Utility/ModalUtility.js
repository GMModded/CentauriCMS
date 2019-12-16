Centauri.Utility.ModalUtility = function(title, description, options, callbacks) {
    var html = "";
    var addHTMLFn = Centauri.Utility.ModalUtility.addHTML;

    var modalSize = "";
    var closeclass = "danger";
    var saveclass = "success";

    if(Centauri.isNotUndefined(options)) {
        if(Centauri.isNotUndefined(options.size)) {
            modalSize = " modal-" + options.size;
        }

        if(Centauri.isNotUndefined(options.close.class)) {
            closeclass = options.close.class;
        }

        if(Centauri.isNotUndefined(options.save.class)) {
            saveclass = options.save.class;
        }
    }

    html = "<div class='modal fade' id='modal' tabindex='-1' role='dialog' aria-labelledby='modallabel' aria-hidden='true'>|</div>";
    html = addHTMLFn(html, "<div class='modal-dialog" + modalSize + "' role='document'>|</div>");
    html = addHTMLFn(html, "<div class='modal-content'>|</div>");
    html = addHTMLFn(html, "<div class='modal-header'>|</div>&&");
    html = addHTMLFn(html, "<h5 class='modal-title' id='modallabel'>" + title + "</h5>|");
    html = addHTMLFn(html, "<button type='button' class='close' data-type='close' aria-label='Close'>|</button>");
    html = addHTMLFn(html, "<span aria-hidden='true'>&times;</span>");
    html = addHTMLFn(html, "<div class='modal-body'>" + description + "</div>&&", "&&");
    html = addHTMLFn(html, "<div class='modal-footer'>|</div>", "&&");
    html = addHTMLFn(html, "<button type='button' data-type='close' class='btn btn-" + closeclass + " waves-effect waves-light'>" + options.close.label + "</button>&&");
    html = addHTMLFn(html, "<button type='button' data-type='save' class='btn btn-" + saveclass + " waves-effect waves-light'>" + options.save.label + "</button>", "&&");

    $("body").append(html);
    $("#modal").modal();

    $("#modal").on("hidden.bs.modal", function(e) {
        $("#modal").modal("dispose");
        $(this).remove();
    });

    $("#modal button").on("click", this, function() {
        var btntype = $(this).data("type");
        $("#modal").modal("hide");

        if(btntype == "close") {
            if(Centauri.isNotUndefined(callbacks.close)) {
                callbacks.close();
            }
        }

        if(btntype == "save") {
            callbacks.save();
        }
    });
};

Centauri.Utility.ModalUtility.addHTML = function(crtHTML, html, split = "|") {
    return (crtHTML.split(split).join(html));
};


/**
 * Example Usage:
 * > Centauri.fn.Modal("Hello...", "...world!", {close: {label: "CLOOOSE"}, save: {label: "SAAAAVE"}}, {size: "lg"});
 */
Centauri.fn.Modal = function(title, description, options, callbacks) {
    return Centauri.Utility.ModalUtility(title, description, options, callbacks);
};
