Centauri.Modal.NewContentElementModal = function() {
    $("button", $editor).on("click", this, function() {
        var action = $(this).data("action");

        if(action == "newContentElement") {
            var rowPos = $(this).parent().parent().attr("data-rowpos");
            var colPos = $(this).parent().attr("data-colpos");
            var sorting = $(this).attr("data-sorting");

            var sorting, $element;
            var insert = $(this).attr("data-insert");

            if(insert == "before") {
                $element = $(this).next();
            }
            if(insert == "after") {
                $element = $(this).next();
            }

            sorting = $element.attr("data-sorting");

            Centauri.fn.Ajax(
                "ContentElements",
                "getConfigCCE",

                {},

                {
                    success: function(data) {
                        Centauri.fn.Modal(
                            "New Content Element",

                            data,

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
                                save: function() {
                                    if(Centauri.isNull(Centauri.Helper.ModalHelper.Element)) {
                                        toastr["error"]("Content Elements Error", "Please select any element in order to create one!");
                                        return;
                                    }

                                    Centauri.fn.Modal.close();
                                    var datas = Centauri.Helper.FieldsHelper($(Centauri.Helper.ModalHelper.Element), ".bottom");

                                    Centauri.fn.Ajax(
                                        "ContentElements",
                                        "newElement",

                                        {
                                            pid: Centauri.Components.PagesComponent.uid,
                                            ctype: Centauri.Helper.ModalHelper.Element.data("ctype"),
                                            datas: JSON.stringify(datas),

                                            rowPos: rowPos,
                                            colPos: colPos,
                                            insert: insert,
                                            sorting: sorting
                                        },

                                        {
                                            success: function(data) {
                                                data = JSON.parse(data);
                                                Centauri.Notify(data.type, data.title, data.description);

                                                Centauri.fn.Ajax(
                                                    "ContentElements",
                                                    "findByPid",

                                                    {
                                                        pid: Centauri.Components.PagesComponent.uid
                                                    },

                                                    {
                                                        success: function(data) {
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
                                                        }
                                                    }
                                                );
                                            },

                                            error: function(data) {
                                                console.error(data);
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

                        $(".element .top").on("click", function() {
                            var $this = $(this);
                            var $element = $this.parent();

                            $(Centauri.Helper.ModalHelper.Element).find(".bottom").slideUp();

                            if(!$(Centauri.Helper.ModalHelper.Element).is($element)) {
                                Centauri.Helper.ModalHelper.Element = $element;
                                $(".bottom", $element).slideToggle();

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
