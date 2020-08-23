Centauri.Section.HeaderSection = () => {
    $("#hamburger").on("click", this, function() {
        $("#hamburger").toggleClass("active");

        Centauri.Event.OnHamburgerClickedEvent();
    });
};
