Centauri.Events.OnOverlayerHiddenEvent = function(closer) {
    let $overlayer = $(".overlayer");

    $overlayer.addClass("hidden");

    if($overlayer.hasClass("overlay-modal")) {
        $overlayer.removeClass("overlay-modal");
    }

    if(closer == "EditorComponent") {
        Centauri.Components.EditorComponent("hide");
    }

    else if(closer == "DashboardView") {
        $("#dashboard, .hamburger").removeClass("active");
    }

    else if(closer == "FileSelectorComponent") {
        $("#file-selector").addClass("inactive");
        $overlayer.attr("data-closer", "EditorComponent");
    }
};
