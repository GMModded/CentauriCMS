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
const Centauri = {};

Centauri.Event = {};
Centauri.Component = {};
Centauri.Service = {};
Centauri.Utility = {};

Centauri.Utility.ContentElementUtility = (ceName) => {
    return $("[data-contentelement='" + ceName + "']");
};

(function() {
    
})();

window.onload = () => {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
        }
    });

    Centauri.Event.OnWindowLoadEvent();

    if(document.querySelectorAll("[data-contentelement='slider']").length > 0) {
        document.querySelectorAll("[data-contentelement='slider']")[0].style.maxHeight="550px";
    }

    // Centauri.Service.UsedCSSService();

    document.addEventListener("DOMContentLoaded", () => {
        Centauri.Service.LazyLoadService();
    });
};
