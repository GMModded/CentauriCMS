Centauri.Events.OnOverlayerHiddenEvent = (closer) => {
    let $overlayer = $(".overlayer");

    $overlayer.addClass("hidden");

    if($overlayer.hasClass("overlay-modal")) {
        $overlayer.removeClass("overlay-modal");
    }

    switch(closer) {
        case "EditorComponent":
            Centauri.Components.EditorComponent("hide");
            break;

        case "DashboardView":
            $("#dashboard, .hamburger").removeClass("active");
            break;

        case "FileSelectorComponent":
            $("#file-selector").addClass("inactive");
            $overlayer.attr("data-closer", "EditorComponent");
            break;

        default:
            break;
    }
};
