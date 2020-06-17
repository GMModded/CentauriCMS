Centauri.Service.UsedCSSService = () => {
    _getCSS = (a) => {
        let sheets = document.styleSheets, o = {};

        for(let i in sheets) {
            let rules = sheets[i].rules || sheets[i].cssRules;

            for(let r in rules) {
                if(a.is(rules[r].selectorText)) {
                    o = $.extend(o, self._CSS2Json(rules[r].style), self._CSS2Json(a.attr("style")));
                }
            }
        }

        return o;
    };

    _CSS2Json = (css) => {
        let s = {};

        if(!css) {
            return s;
        }

        if(css instanceof CSSStyleDeclaration) {
            for(let i in css) {
                if((css[i]).toLowerCase) {
                    s[(css[i]).toLowerCase()] = (css[css[i]]);
                }
            }
        } else if(typeof css == "string") {
            css = css.split("; ");

            for(let i in css) {
                let l = css[i].split(": ");
                s[l[0].toLowerCase()] = (l[1]);
            }
        }

        return s;
    };

    let _endCss = [];

    $("body *").each(function(index, obj) {
        let type = $(this).get(0).tagName;

        if(typeof type != "undefined") {
            type = type.toLowerCase();

            if(typeof obj == "object") {
                if(type != "script" && type != "style") {
                    let css = self._getCSS($(obj));

                    if(Object.keys(css).length > 0) {
                        _endCss.push({
                            element: $(obj),
                            css: css
                        });
                    }
                }
            }
        }
    });

    return _endCss;
};

/*
window.onload = () => {
    var css = Centauri.Service.UsedCSSService();
    var i = 0;
    var genStyleTag = "";

    css.forEach(item => {
        i++;

        let $element = item.element;
        let id = "element-" + i;
        var thisGenStyle = "";

        $element.attr("id", id);

        for(var key in item["css"]) {
            thisGenStyle += key + ":" + item["css"][key] + ";";
        }

        thisGenStyle = "#" + id + "{" + thisGenStyle + "}";
        genStyleTag += thisGenStyle;
    });

    $("head").append("<style>" + genStyleTag + "</style>");
};
*/
