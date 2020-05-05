Centauri.Modal.NewContentElementModal = function() {
    // $("button", $editor).off("click");

    $("button", $editor).on("click", this, function() {
        let $btn = $(this);
        let action = $(this).data("action");

        if(action == "newContentElement") {
            $btn.css("cursor", "wait");

            let $this = $(this);
            Centauri.Modal.NewContentElementModal.UpdateVars($this);

            // sorting = $element.attr("data-sorting");

            // if(Centauri.elExists("#modal-new_contentelement")) {
            //     $("#modal-new_contentelement").modal("show");
            //     $btn.css("cursor", "pointer");
            //     return;
            // }

            Centauri.fn.Ajax(
                "ContentElements",
                "getConfigCCE",

                {},

                {
                    success: (data) => {
                        $(".overlayer").removeClass("hidden");

                        Centauri.fn.Modal(
                            "New Content Element",

                            data,

                            {
                                id: "new_contentelement",
                                size: "xl",
                                closeOnSave: false,
                                cached: false,

                                close: {
                                    label: "",
                                    class: "danger fas fa-times btn-floating"
                                },

                                save: {
                                    label: "",
                                    class: "primary fas fa-plus btn-floating mr-2"
                                }
                            },

                            {
                                ready: () => {
                                    Centauri.Modal.NewContentElementModal.UpdateVars($this);

                                    $btn.css("cursor", "pointer");
                                    Centauri.Components.CreateNewInlineComponent();
                                },

                                save: () => {
                                    Centauri.Modal.NewContentElementModal.UpdateVars($this);

                                    if(Centauri.isNull(Centauri.Helper.ModalHelper.Element)) {
                                        toastr["error"]("Content Elements Error", "Please select any element in order to create one!");
                                        return;
                                    }

                                    let $modal = $("#modal");
                                    $modal.hide();

                                    Centauri.fn.Modal.close();
                                    let datas = Centauri.Helper.FieldsHelper($(Centauri.Helper.ModalHelper.Element), ".bottom");

                                    let tempArr = [];

                                    Object.keys(datas).forEach((data) => {
                                        tempArr.push(datas[data]);
                                    });

                                    let jsonDatas = JSON.stringify(tempArr);

                                    Centauri.fn.Ajax(
                                        "ContentElements",
                                        "newElement",

                                        {
                                            pid: Centauri.Components.PagesComponent.uid,
                                            ctype: Centauri.Helper.ModalHelper.Element.data("ctype"),
                                            datas: jsonDatas,

                                            rowPos: Centauri.Modal.NewContentElementModal.rowPos,
                                            colPos: Centauri.Modal.NewContentElementModal.colPos,
                                            insert: Centauri.Modal.NewContentElementModal.insert,
                                            sorting: Centauri.Modal.NewContentElementModal.sorting,
                                            type: Centauri.Modal.NewContentElementModal.type,
                                            gridsparent: Centauri.Modal.NewContentElementModal.gridsparent,
                                            grids_sorting_rowpos: Centauri.Modal.NewContentElementModal.grids_sorting_rowpos,
                                            grids_sorting_colpos: Centauri.Modal.NewContentElementModal.grids_sorting_colpos
                                        },

                                        {
                                            success: (data) => {
                                                data = JSON.parse(data);
                                                Centauri.Notify(data.type, data.title, data.description);

                                                Centauri.Helper.findByPidHelper(Centauri.Components.PagesComponent.uid);
                                            }
                                        }
                                    );
                                }
                            }
                        );

                        /**
                         * Initializing CKEditor 5
                         */
                        Centauri.Service.CKEditorInitService();

                        $(".element .top").off("click");

                        $(".element .top").on("click", this, function() {
                            var $this = $(this);
                            var $element = $this.parent();

                            $(Centauri.Helper.ModalHelper.Element).find("> .bottom").slideUp();

                            if(!$(Centauri.Helper.ModalHelper.Element).is($element)) {
                                Centauri.Helper.ModalHelper.Element = $element;
                                $("> .bottom", $element).slideToggle();

                                if(Centauri.isUndefined($element.attr("initialized"))) {
                                    $element.attr("initialized", "true");
                                    Centauri.View.ContentElementsView($element);
                                }
                            } else {
                                Centauri.Helper.ModalHelper.Element = null;
                            }
                        });
                    }
                }
            );
        }
    });
};

Centauri.Modal.NewContentElementModal.rowPos = null;
Centauri.Modal.NewContentElementModal.colPos = null;
Centauri.Modal.NewContentElementModal.sorting = null;

Centauri.Modal.NewContentElementModal.$element = null;
Centauri.Modal.NewContentElementModal.insert = null;
Centauri.Modal.NewContentElementModal.type = null;

Centauri.Modal.NewContentElementModal.gridsparent = null;
Centauri.Modal.NewContentElementModal.grids_sorting_rowpos = null;
Centauri.Modal.NewContentElementModal.grids_sorting_colpos = null;

Centauri.Modal.NewContentElementModal.UpdateVars = ($el) => {
    Centauri.Modal.NewContentElementModal.rowPos = $el.parent().parent().attr("data-rowpos");
    Centauri.Modal.NewContentElementModal.colPos = $el.parent().attr("data-colpos");
    Centauri.Modal.NewContentElementModal.sorting = $el.attr("data-sorting");

    Centauri.Modal.NewContentElementModal.$element;
    Centauri.Modal.NewContentElementModal.insert = $el.attr("data-insert");
    Centauri.Modal.NewContentElementModal.type = (Centauri.isNotUndefined($el.attr("data-type")) ? $el.attr("data-type") : "");

    if(Centauri.Modal.NewContentElementModal.type == "ingrid") {
        Centauri.Modal.NewContentElementModal.gridsparent = $el.attr("data-gridsparent");
        Centauri.Modal.NewContentElementModal.grids_sorting_rowpos = $el.attr("data-grid-sorting-rowpos");
        Centauri.Modal.NewContentElementModal.grids_sorting_colpos = $el.attr("data-grid-sorting-colpos");
    }
};
