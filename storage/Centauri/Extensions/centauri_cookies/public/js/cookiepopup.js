var CentauriCookie = function() {
    if(getCookie("cookiebox") == "null" || getCookie("cookiebox") == null) {
        /** Selectors */
        var acceptAllCookiesBtn = document.getElementById("cookiepopup_cookies_acceptall");
        var acceptSelectedCookiesBtn = document.getElementById("cookiepopup_cookies_acceptselected");

        /** String used for function acceptCookies(cookieIdStr) */
        var cookieIdStr = "";

        /** Show more click event handler */
        Array.prototype.forEach.call(document.querySelectorAll("small"), function(node) {
            node.onclick = function() {
                this.parentNode.nextElementSibling.classList.remove("d-none");
                this.parentNode.removeChild(this);
            };
        });

        /** Auto-checking if all child-inputs has been checked or using the parent itself to check all child-input-checkboxes */
        Array.prototype.forEach.call(document.querySelectorAll(".cookie > .ci-switch input.parent"), function(checkNode) {
            checkNode.onchange = function() {
                var bool = false;

                if(!!this.checked) {
                    bool = true;
                }

                Array.prototype.forEach.call(this.parentNode.parentNode.parentNode.querySelectorAll(".childcookies input"), function(subCheckNode) {
                    subCheckNode.checked = bool;
                });
            };
        });
        Array.prototype.forEach.call(document.querySelectorAll(".cookie input.child"), function(childCheckNode) {
            childCheckNode.onchange = function() {
                var allChildsChecked = true;
                var childCookiesParent = this.parentNode.parentNode.parentNode.parentNode.parentNode;

                Array.prototype.forEach.call(childCookiesParent.querySelectorAll("input.child"), function(childCheckNode) {
                    if(!childCheckNode.checked) {
                        allChildsChecked = false;
                    }
                });

                childCookiesParent.parentNode.querySelectorAll("input.parent")[0].checked = allChildsChecked;
            };
        });

        /** Accept all cookies-button - click event */
        acceptAllCookiesBtn.onclick = function() {
            Array.prototype.forEach.call(document.querySelectorAll("#cookiepopup input[type='checkbox']"), function(inputNode) {
                cookieIdStr += inputNode.getAttribute("id") + ",";
            });

            acceptCookies(cookieIdStr);
        };

        /** Accept selected / checked (input fields) cookies-button - click event */
        acceptSelectedCookiesBtn.onclick = function() {
            Array.prototype.forEach.call(document.querySelectorAll("#cookiepopup input[type='checkbox']"), function(inputNode) {
                if(inputNode.checked) {
                    cookieIdStr += inputNode.getAttribute("id") + ",";
                }
            });

            acceptCookies(cookieIdStr);
        };
    }
};

/** ======================================================================================== */
/** @credits https://stackoverflow.com/a/24103596 */

function setCookie(name, value, days) {
    var expires = "";

    if(days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }

    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(";");

    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while(c.charAt(0) == " ") c = c.substring(1, c.length);
        if(c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }

    return null;
}

function eraseCookie(name) {
    document.cookie = name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}

/** ======================================================================================== */

function acceptCookies(cookieIdStr) {
    cookieIdStr = cookieIdStr.replace(/.$/, "");
    setCookie("cookiebox", cookieIdStr, 365);

    document.getElementById("cookiepopup").style.display = "none";
    document.getElementById("cookiepopupoverlayer").style.display = "none";

    location.reload();
}
