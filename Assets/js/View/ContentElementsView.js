Centauri.View.ContentElementsView = ($contentelement) => {
    /**
     * Initializing AccordionComponent for InlineRecords this element may has
     */
    Centauri.Components.AccordionComponent();

    $("[data-centauri-btn]").off("click");

    $("[data-centauri-btn]").on("click", this, function(e) {
        e.preventDefault();

        let $btn = $(this);

        let type = $btn.data("centauri-btn");

        if(type == "addfile" || type == "addimage") {
            let fileListType = "file";

            if(type == "addimage") {
                fileListType = "images";
            }

            let $input = $(this).parent().parent().find("input");

            // Currently not used
            let id = $input.attr("data-id");

            let value = $input.val();

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

                                        CentauriJS.Utilities.Form.FieldHasValueUtility();

                                        Centauri.Components.AccordionComponent();
                                        Centauri.Components.CreateNewInlineComponent();
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

        if(type == "cropimage") {
            let $img = $(this).parents(".bottom").find("img");
            let fileReferenceUid = $img.data("uid");

            Centauri.fn.Ajax(
                "Image",
                "cropByUid",

                {
                    fileReferenceUid: fileReferenceUid
                },

                {
                    success: (data) => {
                        $("section#module_pages").append(data);

                        /** Callback when crop image has been clicked */
                        Centauri.Helper.VariablesHelper.__FN_CROP = (cropper) => {
                            let cropBoxData = cropper.getCropBoxData();
                            let base64 = cropper.getCroppedCanvas().toDataURL();

                            Centauri.Helper.VariablesHelper.__BASE_64 = base64;

                            let contentType = base64.split(";")[0];
                                contentType = contentType.replace("data:", "");

                            $img.attr("src", base64);

                            let data = {
                                cropBoxData: cropBoxData,
                                base64: base64,
                                contentType: contentType
                            };

                            Centauri.fn.Ajax(
                                "Image",
                                "saveCroppedDataByUid",

                                {
                                    fileReferenceUid: fileReferenceUid,
                                    data: data
                                },

                                {
                                    success: (data) => {
                                        data = JSON.parse(data);
                                        Centauri.Notify(data.type, data.title, data.description);
                                    }
                                }
                            )

                            $("section#content > section > #cropper").remove();
                        };
                    }
                }
            );
        }

        else {
            console.warn("Centauri.View.ContentElementsView: There's no condition-handling for the type: '" + type + "'");
        }
    });
};
