const Centauri = {};

/**
 * Centauri Environment
 */
Centauri.Env = "Development";


/**
 * Centauri Core
 */
Centauri.Events = {};
Centauri.Components = {};
Centauri.Utility = {};
Centauri.View = {};


/**
 * Centauri Core registrations
 */
Centauri.load = function() {
    Centauri_loadFunctions();

    if(Centauri.isNotUndefined(CentauriEnv)) {
        CentauriEnv();
    }

    Centauri.Utility.Ajax();

    Centauri.View.LoginView();

    Centauri.Components.ModulesComponent({
        type: "init"
    });
    Centauri.Components.EditorComponent.init();
};


/**
 * DOM ready - loading Centauri
 */
$(document).ready(function() {
    Centauri.load();
});
