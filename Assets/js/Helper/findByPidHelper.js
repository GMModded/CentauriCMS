// Centauri.Helper.findByPidHelper(Centauri.Components.PagesComponent.uid);

Centauri.Helper.findByPidHelper = (pid, $contentelement=null) => {
    Centauri.fn.Ajax(
        "ContentElements",
        "findByPid",

        {
            pid: pid
        },

        {
            success: function(data) {
                Centauri.fn.Ajax.Overlayer = true;

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
            }
        }
    );
};
