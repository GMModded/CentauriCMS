Centauri.Modal.ModelModal = function() {
    $(".element .top").on("click", function() {
        var $this = $(this);
        var $element = $this.parent();

        $(Centauri.Helper.ModalHelper.Element).find(".bottom").slideUp();

        if(!$(Centauri.Helper.ModalHelper.Element).is($element)) {
            Centauri.Helper.ModalHelper.Element = $element;

            if(!Centauri.Helper.VariablesHelper.__ModalInputFixList.includes($element)) {
                Centauri.Helper.VariablesHelper.__ModalInputFixList.push($element);

                $("input, select, .md-textarea", $element).each(function() {
                    var id = $(this).attr("id");
                    Centauri.Helper.VariablesHelper.__ModalInputFixCounter++;
                    $(this).attr("id", id + "-" + Centauri.Helper.VariablesHelper.__ModalInputFixCounter);
                });
            }

            $(".bottom", $element).slideToggle();
        } else {
            Centauri.Helper.ModalHelper.Element = null;
        }
    });
};
