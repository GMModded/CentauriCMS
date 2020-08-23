Centauri.Service.PusherService = () => {
    /*
    // Pusher.logToConsole = true;

    // Connection
    let pusher = new Pusher("4f412ccc501bb244144b", {
        cluster: "eu",
        forceTLS: true
    });

    // Channel
    let channel = pusher.subscribe("centauri-channel");

    channel.bind("pagereload", (data) => {
        let message = data.message;

        if(Centauri.isNotUndefined(message["reloadpage"])) {
            if(message["reloadpage"]) {
                if(Centauri.Component.ATagComponent.canReload) {
                    Centauri.Component.ATagComponent.canReload = false;

                    let href = Centauri.Component.ATagComponent.lastHref;
                    Centauri.Component.ATagComponent.ajaxRequest(href, () => {
                        setTimeout(() => {
                            Centauri.Component.ATagComponent.canReload = true;
                        }, 1500);
                    });
                }
            }
        }
    });
    */
};
