/**
 * Listener for the EditorComponent
 * This will mainly fires events e.g. Select-onChange or Input-onKeyDown etc.
 */
Centauri.Listener.EditorListener = () => {
    $("form .mdb-select", $editor).on("change", this, function() {
        Centauri.Events.EditorComponent.Select.OnChange(this);
    });

    $("form .md-form input.form-control", $editor).on("keydown", this, function(e) {
        Centauri.Events.EditorComponent.Input.OnKeyDown(this, e);
    });
};
