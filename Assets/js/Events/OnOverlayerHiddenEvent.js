Centauri.Events.OnOverlayerHiddenEvent = function(closer) {
    $(".overlayer").addClass("hidden");

    if(closer == "EditorComponent") {
        Centauri.Components.EditorComponent("hide");
    }

    if(closer == "DashboardView") {
        $("#dashboard, .hamburger").removeClass("active");
    }
};
