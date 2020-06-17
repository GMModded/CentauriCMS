Centauri.View.ContentElementsView = ($contentelement) => {
    /**
     * Initializing AccordionComponent for InlineRecords this element may has
     */
    Centauri.Components.AccordionComponent();

    $("[data-centauri-btn]").off("click");

    $("[data-centauri-btn]").on("click", this, function(e) {
        e.preventDefault();

        let $btn = $(this);

        let data = $btn.data("centauri-btn");
        let type = data.type;

        if(type == "addfile" || type == "addimage") {
            let fileListType = "file";

            if(type == "addimage") {
                fileListType = "images";
            }

            let $input = $(this).parent().parent().find("input");

            // Currently not used
            let id = $input.attr("data-id");

            let value = $input.val();

            // For validation
            let required = $(this).data("required");
            let minItems = $(this).data("minitems");
            let maxItems = $(this).data("maxitems");

            let $accordions = $("> .accordions", $input.parent());

            Centauri.fn.Ajax(
                "File",
                "list",

                {
                    value: value,
                    type: fileListType
                },

                {
                    success: (data) => {
                        let html = data;
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

                        Centauri.Components.FileSelectorComponent("show", function(data) {
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
                                    }
                                }
                            );
                        });
                    }
                }
            );
        }

        if(type == "button") {
            let action = data.action;

            if(action == "generate-slug") {
                let sourceFieldDataId = data.sourceField;

                let value = Centauri.Helper.GetParentCiFieldValueByDataIdHelper($btn, sourceFieldDataId);
                seoUrl = Centauri.Utility.SeoUrlUtility(value);

                let $element = Centauri.Helper.GetCiFieldByBtn($btn);
                $element.val(seoUrl);
            } else {
                console.warn("Centauri.View.ContentElementsView: There's no condition-handling for the action: '" + action + "'");
            }
        }

        else {
            console.warn("Centauri.View.ContentElementsView: There's no condition-handling for the type: '" + type + "'");
        }
    });
};
