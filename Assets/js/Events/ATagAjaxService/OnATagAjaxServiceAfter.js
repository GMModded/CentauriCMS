Centauri.Events.OnATagAjaxServiceAfter = (type, data) => {
    let handler = data.handler;
    let action = data.action;

    if(type == "error") {
        Centauri.Notify("error", "aaa", "bbbb");
        return;
    }

    if(handler == "Cache") {
        if(action == "flushBackend") {
            $(".modal").modal("hide").modal("dispose").remove();
            $("body > .ck-rounded-corners").remove();
        }
    }
};
