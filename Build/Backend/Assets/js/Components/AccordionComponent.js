Centauri.Components.AccordionComponent = () => {
    $(".accordions .accordion").each(function() {
        var $accordion = $(this);

        $(".top", $accordion).off("click");

        $(".top", $accordion).on("click", this, function() {
            $(this).parent().find("> .bottom").slideToggle();
        });
    });
};
