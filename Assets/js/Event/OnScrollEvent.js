Centauri.Event.OnScrollEvent = () => {
    /**
     * Header Sticky
     */
    if($("html, body").scrollTop() > 75) {
        $("#header .container-fluid").removeClass("sticked");
    } else {
        $("#header .container-fluid").addClass("sticked");
    }
};
