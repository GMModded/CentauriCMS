/**
 * Centauri
 * 
 * @website https://centauricms.de/
 * @author m.sediqi@centauricms.de
 * @file Centauri Core JS file for FE
 * @copyright M. S. 2019-2020
 * 
 * © 2019-2020 All rights reserved.
 */
var Centauri = {} || Centauri;
CentauriCoreFunctions();

Centauri.Event = {};
Centauri.Component = {};
Centauri.Section = {};
Centauri.Service = {};
Centauri.Utility = {};

Centauri.Breakpoint = "";

Centauri.Utility.ContentElementUtility = (ceName) => {
    return $("[data-contentelement='" + ceName + "']");
};

window.onload = () => {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
        }
    });

    Centauri.Event.OnWindowLoadEvent();

    document.addEventListener("DOMContentLoaded", () => {
        Centauri.Service.LazyLoadService();
    });
};
