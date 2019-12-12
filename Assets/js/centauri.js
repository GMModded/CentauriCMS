const Centauri = {};

/**
 * Centauri Environment
 */
Centauri.Env = "Development";

/**
 * Centauri Module - ID
 * Default one when logging into the backend
 */
Centauri.defaultModule = "dashboard";


/**
 * Centauri Core
 */
Centauri.Module = Centauri.defaultModule;
Centauri.Events = {};
Centauri.Listeners = {};
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
