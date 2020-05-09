// Usage: Centauri.Helper.findByPidHelper(Centauri.Components.PagesComponent.uid);

Centauri.Helper.findByPidHelper = (pid, $contentelement = null) => {
    $(".overlayer").addClass("findByPid").removeClass("hidden");
    $(".loader").removeClass("hidden");

    Centauri.fn.Ajax(
        "ContentElements",
        "findByPid",

        {
            pid: pid
        },

        {
            success: function(data) {
                // Centauri.fn.Ajax.Overlayer = true;
                $(".overlayer").addClass("hidden").removeClass("findByPid");
                $(".loader").addClass("hidden");

                var $container = $("#editor > .bottom > .container");
                $container.html(data);

                /**
                 * Initializing edit-button for elements
                 */
                Centauri.Helper.PagesHelper($container);

                /**
                 * Registering click-event for newCEButton
                 */
                Centauri.Modal.NewContentElementModal();

                /**
                 * Initializing CKEditor 5
                 */
                Centauri.Service.CKEditorInitService();

                /**
                 * Initializing AccordionComponent for InlineRecords this element may has
                 */
                Centauri.Components.AccordionComponent();

                /**
                 * Sorting-Service for the rendered Content-Elements in the EditorComponent
                 */
                Centauri.Service.CESortingService();
            }
        }
    );
};
