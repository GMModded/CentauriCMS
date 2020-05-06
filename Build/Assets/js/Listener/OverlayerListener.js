Centauri.Listener.OverlayerListener = function() {
    $(".overlayer").on("click", this, function() {
        let closer = $(this).attr("data-closer");

        if(closer != "BE_LOADING") {
            Centauri.Events.OnOverlayerHiddenEvent(closer);
        }
    });
};
