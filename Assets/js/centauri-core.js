/**
 * Centauri Core
 * 
 * Function which will be called when Centauri.load() has been called.
 * Registers core functions e.g. Env, Versions etc.
 */
function Centauri_loadFunctions() {
    /**
     * @function isDev - Handles if the environment is on Development
     * @return {boolean}
     */
    Centauri.isDev = function() {
        return (Centauri.Env == "Dev" || Centauri.Env == "Development");
    };
    /**
     * @function isDevelopment - Handles if the environment is on Development
     * @return {boolean}
     */
    Centauri.isDevelopment = function() {
        return (Centauri.Env == "Dev" || Centauri.Env == "Development");
    };

    /**
     * @function isProd - Handles if the environment is on Production
     * @return {boolean}
     */
    Centauri.isProd = function() {
        return (Centauri.Env == "Prod" || Centauri.Env == "Production");
    };
    /**
     * @function isProduction - Handles if the environment is on Production
     * @return {boolean}
     */
    Centauri.isProduction = function() {
        return (Centauri.Env == "Prod" || Centauri.Env == "Production");
    };


    /**
     * @function isUndefined - Handles conditions for variable if it's undefined
     * @param variable - the variable of this function
     * @return {boolean}
     */
    Centauri.isUndefined = function(variable) {
        return (typeof variable == undefined || typeof variable == "undefined");
    };

    /**
     * @function isNotUndefined - Handles conditions for variable if it's not undefined
     * @param variable - the variable of this function
     * @return {boolean}
     */
    Centauri.isNotUndefined = function(variable) {
        return (typeof variable != undefined && typeof variable != "undefined");
    };

    /**
     * @function eExists - Checks if a given element (by selector) exists or not
     * @param selector - the selector for this function
     * @return {boolean}
     */
    Centauri.elExists = function(selector) {
        return ($(selector).length === 1 ? true : false);
    };
}
