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
 * 
 * @function Centauri.load
 * @returns {void}
 */
Centauri.load = function() {
    /**
     * This function is 
     */
    CentauriCoreFunctions();

    /**
     * Condition whether CentauriEnv is defined - since it's for each environment maybe necessary, maybe not - therefor this condition
     * to handle it properly in case CentauriEnv does not exists.
     */
    if(Centauri.isNotUndefined(CentauriEnv)) {
        CentauriEnv();
    }

    /**
     * Window related stuff (events etc.)
     */
    Centauri.Events.Window.OnLoadResize();

    /**
     * Utilities
     */
    Centauri.Utility.Ajax();

    /**
     * DAP - DynamicAjaxPushLoader
     */
    Centauri.DAPLoader();

    /**
     * Views
     */
    Centauri.View.LoginView();
    Centauri.View.DashboardView();

    /**
     * Initialization of Components
     */
    Centauri.Components.ModulesComponent({type: "init"});
    Centauri.Components.EditorComponent.init();

    /**
     * Listeners which register events mainly
     */
    Centauri.Listener.OverlayerListener();
};


/**
 * DOM ready - Initializing Centauri
 * 
 * @param {function} function - Self calling function by jQuery
 * @returns {void}
 */
$(document).ready(function() {
    /**
     * Initializing Centauri Core Functions by this such as Centauri Core itself.
     */
    Centauri.load();

    /**
     * Initializations - mainly for functions which should happen after Centauri.load() has been called (async).
     */
    Centauri.Init.HeaderInit();
});
