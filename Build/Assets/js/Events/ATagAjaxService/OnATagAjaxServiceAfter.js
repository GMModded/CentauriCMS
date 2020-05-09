Centauri.Events.OnATagAjaxServiceAfter = (type, data) => {
    let handler = data.handler;
    let action = data.action;

    if(type == "error") {
        Centauri.Notify("error", "Action failed!", "'" + data.handler + "'-Handler failed for the action '" + data.action + "'");

        console.error("Centauri.Events.OnATagAjaxServiceAfter: The action '" + data.action + "' for Handler '" + data.handler + "' failed due to:");
        console.error("  > " + data.error);

        return;
    }

    if(handler == "Cache") {
        if(action == "flushBackend") {
            $(".modal").modal("hide").modal("dispose").remove();
            $("body > .ck-rounded-corners").remove();
        }
    }
};
