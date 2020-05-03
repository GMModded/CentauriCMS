Centauri.Helper.PagesHelper = function($container) {
    var $tops = $(".top", $container);

    $tops.each(function() {
        let $top = $(this);

        if(!$top.hasClass("has-init")) {
            $top.addClass("has-init");

            $(".edit", $top).on("click", this, function() {
                var $this = $(this);

                var $top = $this.parent().parent();
                $contentelement = $top.parent();

                $contentelement.toggleClass("active");

                if(!Centauri.elExists($(".data > .fields", $contentelement))) {
                    if(Centauri.isUndefined($contentelement.data("loading-state"))) {
                        $(".top .button-view .edit i", $contentelement).addClass("d-none disabled");
                        $(".top .button-view .edit", $contentelement).append("<span class='spinner-grow spinner-grow-sm' role='status' aria-hidden='true'></span>");

                        Centauri.Helper.FindFieldsByUidHelper($contentelement, $this);
                    }
                } else {
                    $fields = $contentelement.find(".data > .fields");

                    $fields.slideToggle(function() {
                        $this.toggleClass("btn-primary btn-info");
                    });
                }
            });
        }
    });
};
