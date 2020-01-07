/**
 * Centauri HistoryPushLoader / DynamicAjaxPopstate Loader - HPL/DAP
 */
Centauri.DAPLoader = function() {
    var url = location.origin + Centauri.Utility.PathsUtility.root + "centauri";

    window.onpopstate = function() {
        var moduleid = location.href.replace(url, "");
            moduleid = moduleid.replace("/", "");

        Centauri.DAPLoader.historyPushState = false;

        Centauri.Components.ModulesComponent({
            type: "load",
            module: moduleid
        });
    };
};

Centauri.DAPLoader.historyPushState = true;
