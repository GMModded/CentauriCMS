Centauri.Helper.PagesHelper = function() {
    $(".content-element").draggable({
        // containment: "parent",
        revert: "invalid",

        stop: function() {
            $(this).draggable("option", "revert", "invalid");
        }
    });

    $(".content-element").droppable({
        greedy: true,
        tolerance: "touch",

        drop: function(event, ui) {
            ui.draggable.draggable("option", "revert", true);
        }
    });

    $(".allowed-pos").droppable({
        hoverClass: "highlight",
        tolerance: "fit"
    });

    $(".content-element").on("dragstart", function() {
        $(this).addClass("dragging");
        $(".allowed-pos").removeClass("hidden");
    });
    
    $(".content-element").on("dragstop", function() {
        $(this).removeClass("dragging");
        $(".allowed-pos").addClass("hidden");
    });
};
