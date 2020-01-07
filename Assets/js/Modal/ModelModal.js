Centauri.Modal.ModelModal = function() {
    $(".element .top").on("click", function() {
        var $this = $(this);
        var $element = $this.parent();

        $(Centauri.Helper.ModalHelper.Element).find(".bottom").slideUp();

        if(!$(Centauri.Helper.ModalHelper.Element).is($element)) {
            Centauri.Helper.ModalHelper.Element = $element;
            $(".bottom", $element).slideToggle();
        } else {
            Centauri.Helper.ModalHelper.Element = null;
        }
    });
};
