Centauri.Utility.AjaxUtility = (url, data, callbacks) => {
    if(Centauri.isUndefined(data)) {
        throw new DOMException("AjaxUtility - Can't run an AJAX-call without data. Add atleast an empty array|object for passing it and define your callbacks.");
    }

    if(Centauri.isUndefined(callbacks.success)) {
        throw new DOMException("AjaxUtility - Can't run an AJAX-call without a callbacks.success-scope!");
    }

    $.ajax({
        url: url,

        data: data,

        success: (scsData) => {
            callbacks.success(scsData);
        },

        error: (errData) => {
            if(Centauri.isNotUndefined(callbacks.error)) {
                callbacks.error(errData);
            }
        },

        complete: (complData) => {
            if(Centauri.isNotUndefined(callbacks.complete)) {
                callbacks.complete(complData);
            }
        }
    })
};

window.addEventListener("load", () => {
    Centauri.Utility.AjaxUtility("/csrf-token.php", null, {
        success: (data) => {
            $("head").append("<meta name='csrf-token' content='" + data + "'>");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": data
                }
            });
        }
    });
});
