$.fn.hasAttr = (attr) => {
    return (typeof $(this).attr(attr) != "undefined");
};
