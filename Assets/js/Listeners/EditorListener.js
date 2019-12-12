Centauri.Listeners.EditorListener = function() {
    // Avoids event runs multiple time each time EditorListener() function gets called.
    // That's why .off() and after all that applying all .on()-listeners

    $("form .mdb-select", $editor).off();

    $("form .mdb-select", $editor).on("change", this, function() {
        Centauri.Events.EditorComponent.Select.OnChange(this);
    });
};
