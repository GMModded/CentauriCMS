Centauri.Components.AccordionComponent = () => {
    $(".accordions .accordion:not([initialized])").each(function() {
        var $accordion = $(this);
        $accordion.attr("initialized", "true");

        $(".top", $accordion).on("click", this, function() {
            $(this).parent().find("> .bottom").slideToggle();
        });
    });
};
