Centauri.fn.Ajax = function(ajax, method, data, callbacks, options) {
    var url = Centauri.Utility.PathsUtility.root + Centauri.Utility.PathsUtility.centauri + Centauri.Utility.PathsUtility.ajax + ajax + "/" + method;

    if(Centauri.fn.Ajax.Overlayer) {
        $("#maincontent .overlayer").removeClass("hidden");
        $("#maincontent .overlayer .loader").removeClass("hidden");
    }

    $.ajax({
        url: url,
        type: "POST",

        data: data,

        success: function(data) {
            if(Centauri.isNotUndefined(options)) {
                if(
                    Centauri.isNotUndefined(options.closeEditorComponentOnSuccess)
                &&
                    (options.closeEditorComponentOnSuccess)
                ) {
                    Centauri.Components.EditorComponent("hide");

                    if(Centauri.Components.EditorComponent.ClearOnSave) {
                        setTimeout(function() {
                            Centauri.Components.EditorComponent("clear", {
                                forceClear: true
                            });
                        }, Centauri.Components.EditorComponent.TransitionTime);
                    }
                }
            }

            if(Centauri.fn.Ajax.Overlayer) {
                $("#maincontent .overlayer").addClass("hidden");
                $("#maincontent .overlayer .loader").addClass("hidden");
            }

            callbacks.success(data);
        },

        error: function(data) {
            if(Centauri.fn.Ajax.Overlayer) {
                $("#maincontent .overlayer .loader").addClass("hidden");
            }

            if(Centauri.isNotUndefined(callbacks.error)) {
                callbacks.error(data);
            } else {
                console.error(data);
            }
        },

        complete: function(data) {
            if(Centauri.isNotUndefined(callbacks.complete)) {
                callbacks.complete(data);
            }
        }
    });
};

Centauri.Utility.Ajax = function() {
    Centauri.fn.Ajax.Overlayer = true;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
        }
    });
};

window.onload = function() {
    Centauri.Utility.Ajax();

    $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
        if(thrownError == "Internal Server Error") {
            Centauri.Notify("error", thrownError, jqxhr.responseText);
        }
    });
};
