Centauri.Events.OnOverlayerHiddenEvent = function(closer) {
    $(".overlayer").addClass("hidden");

    if(closer == "EditorComponent") {
        Centauri.Components.EditorComponent("hide");
    }

    else if(closer == "DashboardView") {
        $("#dashboard, .hamburger").removeClass("active");
    }

    else if(closer == "FileSelectorComponent") {
        $("#file-selector").addClass("inactive");
        $(".overlayer").attr("data-closer", "EditorComponent");
    }
};
