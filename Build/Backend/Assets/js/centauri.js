/**
 * Centauri
 * 
 * @website https://centauricms.de/
 * @author m.sediqi@centauricms.de
 * @file Centauri Core JS file for BE
 * @copyright Matiullah Sediqi 2019-2020
 * 
 * © 2019-2020 All rights reserved.
 */
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
Centauri.Init = {};

Centauri.Service = {};
Centauri.Utility = {};

Centauri.Module = Centauri.defaultModule;

Centauri.fn = {};

Centauri.Helper = {};
Centauri.Helper.VariablesHelper = {};

Centauri.Events = {};
Centauri.Listener = {};
Centauri.Components = {};
Centauri.Modal = {};
Centauri.View = {};


/**
 * Centauri Core registrations
 */
Centauri.load = function() {
    Centauri_loadFunctions();

    if(Centauri.isNotUndefined(CentauriEnv)) {
        CentauriEnv();
    }

    // Window related stuff (events etc.)
    Centauri.Events.Window.OnLoadResize();

    // Utilities
    Centauri.Utility.Ajax();

    // DynamicAjaxPushLoader - DAP
    Centauri.DAPLoader();

    // Views
    Centauri.View.LoginView();
    Centauri.View.DashboardView();

    // Initialization of Components
    Centauri.Components.ModulesComponent({type: "init"});
    Centauri.Components.EditorComponent.init();

    // Listeners which register events mainly
    Centauri.Listener.OverlayerListener();
};


/**
 * DOM ready - loading Centauri
 */
$(document).ready(function() {
    Centauri.load();

    // Init stuff
    Centauri.Init.HeaderInit();
});
