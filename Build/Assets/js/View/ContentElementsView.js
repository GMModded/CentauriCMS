Centauri.View.ContentElementsView = ($contentelement) => {
    /**
     * Initializing AccordionComponent for InlineRecords this element may has
     */
    Centauri.Components.AccordionComponent();

    $("[data-centauri-btn]").off("click");

    $("[data-centauri-btn]").on("click", function(e) {
        e.preventDefault();

        var type = $(this).data("centauri-btn");
        var fileListType = "file";

        if(type == "addimage") {
            fileListType = "images";
        }

        if(type == "addfile" || type == "addimage") {
            var $input = $(this).parent().parent().find("input");

            // Currently not used
            var id = $input.attr("data-id");

            var value = $input.val();

            // For validation
            var required = $(this).data("required");
            var minItems = $(this).data("minitems");
            var maxItems = $(this).data("maxitems");

            var $accordions = $("> .accordions", $input.parent());

            Centauri.fn.Ajax(
                "File",
                "list",

                {
                    value: value,
                    type: fileListType
                },

                {
                    success: (data) => {
                        var html = data;
                        $("body").append(html);

                        setTimeout(() => {
                            $("#file-selector").removeClass("inactive");
                            $(".overlayer").toggleClass("hidden overlay-modal");
                            $(".overlayer").attr("data-closer", "FileSelectorComponent");

                            setTimeout(() => {
                                if($(".accordion", $accordions).length != 0) {
                                    $(".accordion", $accordions).each(function(index) {
                                        let uid = $(this).attr("data-uid");

                                        if(Centauri.Components.FileSelectorComponent.AnimatedSelectedFiles) {
                                            $("#file-selector .items .item[data-uid='" + uid + "']").delay(165 * index).queue(function() {
                                                $(this).addClass("selected");
                                            });
                                        } else {
                                            $("#file-selector .items .item[data-uid='" + uid + "']").addClass("selected");
                                        }
                                    });
                                }
                            }, (510));
                        }, 150);

                        Centauri.Components.FileSelectorComponent("show", (data) => {
                            let selectedFiles = data.selectedFiles,
                                selectedUids = data.selectedUids;

                            $input.val(selectedUids);

                            Centauri.fn.Ajax(
                                "InlineRecords",
                                "list",

                                {
                                    type: "files",
                                    uids: selectedUids
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

                            // Centauri.fn.Modal.close();
                        });
                    },

                    error: (data) => {
                        console.error(data);
                    }
                }
            );
        }
    });
};
