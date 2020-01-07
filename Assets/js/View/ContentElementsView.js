Centauri.View.ContentElementsView = ($contentelement) => {
    /**
     * Initializing AccordionComponent for InlineRecords this element may has
     */
    Centauri.Components.AccordionComponent();

    $("[data-centauri-btn]", $contentelement).each(function() {
        var $contentelement = $(this).parent().parent().parent().parent().parent();
        var $btn = $(this);

        $btn.on("click", function(e) {
            e.preventDefault();

            var type = $(this).data("centauri-btn");

            if(type == "addimage") {
                var $input = $(this).parent().parent().find("input");
                var id = $input.attr("id");

                var value = $input.val();
                var required = $(this).data("required");
                var minItems = $(this).data("minitems");
                var maxItems = $(this).data("maxitems");

                var $accordions = $("> .accordions", $input.parent());

                Centauri.fn.Ajax(
                    "ImageModal",
                    "list",

                    {
                        value: value
                    },

                    {
                        success: (data) => {
                            var html = data;
                            
                            Centauri.fn.Modal(
                                Centauri.__trans.modules["filelist"],
                                html,

                                {
                                    size: "xl",
                                    closeOnSave: false,

                                    close: {
                                        label: "",
                                        class: "danger fas fa-times"
                                    },

                                    save: {
                                        label: "",
                                        class: "success fas fa-save"
                                    }
                                },

                                {
                                    save() {
                                        var selectedFiles = [];

                                        $("#modal table tr td .form-check > input").each(function() {
                                            var $input = $(this);

                                            if($input.prop("checked")) {
                                                selectedFiles.push({
                                                    "uid": $input.attr("id").split("_")[1]
                                                });
                                            }
                                        });

                                        if(selectedFiles.length > maxItems) {
                                            Centauri.Notify(
                                                "error",
                                                "File Validation",
                                                "Selected too many files - max. " + maxItems + " are allowed!"
                                            );

                                            return;
                                        }

                                        var stringUids = "";

                                        $.each(selectedFiles, function(index, obj) {
                                            stringUids += obj.uid;

                                            if(selectedFiles.length - 1 != index) {
                                                stringUids += ",";
                                            }
                                        });

                                        $input.val(stringUids);

                                        Centauri.fn.Ajax(
                                            "InlineRecords",
                                            "list",

                                            {
                                                type: "files",
                                                uids: stringUids
                                            },

                                            {
                                                success: (data) => {
                                                    $accordions.html(data);
                                                    Centauri.Components.AccordionComponent();
                                                },

                                                error: (data) => {
                                                    console.error(data);
                                                }
                                            }
                                        );

                                        Centauri.fn.Modal.close();
                                    }
                                }
                            );
                        },

                        error: (data) => {
                            console.error(data);
                        }
                    }
                );
            }
        });
    });
};
