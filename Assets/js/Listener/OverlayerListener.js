Centauri.Listener.OverlayerListener = function() {
    $(".overlayer").on("click", function() {
        var closer = $(this).attr("data-closer");
        Centauri.Events.OnOverlayerHiddenEvent(closer);
    });
};
