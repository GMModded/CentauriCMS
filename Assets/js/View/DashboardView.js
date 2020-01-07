Centauri.View.DashboardView = function() {
    Centauri.View.DashboardView.fn__toggle = function(isOpen = false) {
        if(isOpen) {
            Centauri.Components.EditorComponent("close");

            setTimeout(function() {
                $(".overlayer").removeClass("hidden");
                $(".overlayer").attr("data-closer", "DashboardView");
            }, (Centauri.Components.EditorComponent.TransitionTime + 1));
        } else {
            $(".overlayer").toggleClass("hidden");
            $(".overlayer").attr("data-closer", "DashboardView");
        }

        $(".hamburger").toggleClass("active");
        $("#dashboard").toggleClass("active");
    };

    $(".hamburger").on("click", function() {
        if(Centauri.Components.EditorComponent("isOpen")) {
            Centauri.fn.Modal(
                Centauri.__trans.modals.areyousure,
                Centauri.__trans.EditorComponent.toggleHamburger,

                {
                    close: {
                        label: Centauri.__trans.modals.btn_cancel,
                        class: "warning"
                    },

                    save: {
                        label: Centauri.__trans.modals.btn_toggle,
                        class: "danger"
                    }
                },

                {
                    save() {
                        Centauri.View.DashboardView.fn__toggle(true);
                    }
                }
            );
        } else {
            Centauri.View.DashboardView.fn__toggle();
        }
    });

    $("#language").materialSelect();

    $("#language").on("change", this, function() {
        location.href = Centauri.Utility.PathsUtility.root + Centauri.Utility.PathsUtility.centauri + Centauri.Utility.PathsUtility.action + "Backend/language/" + $("#language").val();
    });
};
