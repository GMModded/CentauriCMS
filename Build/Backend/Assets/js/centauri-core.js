/**
 * CentauriCoreFunctions
 * 
 * Function which will be called when Centauri.load() has been called
 * Registers core functions e.g. Env, Versions etc.
 * This function can be used in extensions such as in the centauri-env.js file.
 * 
 * @function CentauriCoreFunctions
 * @return {void}
 */
function CentauriCoreFunctions() {
    /**
     * Handles if the environment is on Development
     * 
     * @function isDev
     * @return {boolean}
     */
    Centauri.isDev = function() {
        return (Centauri.Env == "Dev" || Centauri.Env == "Development");
    };

    /**
     * Handles if the environment is on Development
     * 
     * @function isDevelopment
     * @return {boolean}
     */
    Centauri.isDevelopment = function() {
        return (Centauri.Env == "Dev" || Centauri.Env == "Development");
    };

    /**
     * Handles if the environment is on Production
     * 
     * @function isProd
     * @return {boolean}
     */
    Centauri.isProd = function() {
        return (Centauri.Env == "Prod" || Centauri.Env == "Production");
    };

    /**
     * Handles if the environment is on Production
     * 
     * @function isProduction
     * @return {boolean}
     */
    Centauri.isProduction = function() {
        return (Centauri.Env == "Prod" || Centauri.Env == "Production");
    };


    /**
     * Handles conditions for variable if it's undefined
     * 
     * @function isUndefined
     * @param {mixin} variable The variable of this function
     * @return {boolean}
     */
    Centauri.isUndefined = function(variable) {
        return (typeof variable == undefined || typeof variable == "undefined");
    };

    /**
     * Handles conditions for variable if it's not undefined
     * 
     * @function isNotUndefined
     * @param {mixin} variable The variable of this function
     * @return {boolean}
     */
    Centauri.isNotUndefined = function(variable) {
        return (typeof variable != undefined && typeof variable != "undefined");
    };

    /**
     * Handles conditions for variable if it's null
     * 
     * @function isNull
     * @param {mixin} variable The variable of this function
     * @return {boolean}
     */
    Centauri.isNull = function(variable) {
        return (variable === null);
    };

    /**
     * Handles conditions for variable if it's not null
     * 
     * @function isNotNull
     * @param {mixin} variable The variable of this function
     * @return {boolean}
     */
    Centauri.isNotNull = function(variable) {
        return (variable !== null);
    };

    /**
     * Checks if a given element (by selector) exists or not
     * 
     * @function elExists
     * @param {element} selector The selector for this function
     * @return {boolean}
     */
    Centauri.elExists = function(selector) {
        if($(selector).hasClass("modal")) {
            if($(selector).hasClass("show")) {
                return true;
            }
        }

        return ($(selector).length === 1 ? true : false);
    };

    /**
     * Checks if a string contains a specific (given) char
     * 
     * @function strContains
     * @param {string} string
     * @param {string} char
     * @return {boolean}
     */
    Centauri.strContains = function(string, char, ignoreCamelCase = false) {
        var parameter = "";

        if(Centauri.isUndefined(string)) {
            parameter = "string";
        }
        if(Centauri.isUndefined(char)) {
            parameter = "char";
        }

        if(parameter != "") {
            console.error("Centauri-Core: strContains(string, char) can't be called without a " + parameter + "-parameter!");
            return;
        }

        if(ignoreCamelCase) {
            return (~(string.toLowerCase()).indexOf(char.toLowerCase())) ? true : false;
        }

        return (~string.indexOf(char)) ? true : false;
    };

    /**
     * Replaces a specific part of a string with a given value
     * 
     * @function strReplace
     * @param {string} string
     * @param {string} replace
     * @return {string}
     */
    Centauri.strReplace = function(string, searchValue, replaceValue) {
        return string.replace(searchValue, replaceValue, string);
    };

    /**
     * Returns whether Debugging for Centauri is enabled/disabled
     * 
     * @function isDebugging
     * @return {boolean}
     */
    Centauri.isDebugging = () => {
        return Centauri.Debugging;
    };
}
