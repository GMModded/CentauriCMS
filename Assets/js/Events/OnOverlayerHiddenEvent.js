Centauri.Events.OnOverlayerHiddenEvent = function(closer) {
    if(closer == "EditorComponent") {
        Centauri.Components.EditorComponent("hide");
    }
};
