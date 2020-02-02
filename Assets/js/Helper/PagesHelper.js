Centauri.Helper.PagesHelper = function($container) {
    var $tops = $(".top", $container);

    $tops.each(function() {
        var $top = $(this);

        $(".edit", $top).on("click", function() {
            var $this = $(this);

            var $top = $this.parent();
            $contentelement = $top.parent();

            $contentelement.toggleClass("active");

            if(!Centauri.elExists($contentelement.find(".fields"))) {
                Centauri.fn.Ajax(
                    "ContentElements",
                    "findFieldsByUid",

                    {
                        uid: $contentelement.attr("data-uid")
                    },

                    {
                        success: function(data) {
                            $(".overlayer").removeClass("hidden");

                            $contentelement.append(data);

                            Centauri.View.ContentElementsView($contentelement);

                            Centauri.Components.CreateNewInlineComponent();
                            Centauri.Components.AccordionComponent();

                            $(".fields select", $contentelement).materialSelect();

                            /**
                             * Initializing CKEditor 5
                             */
                            Centauri.Service.CKEditorInitService();

                            $("> .row button", $contentelement).on("click", function() {
                                var uid = $(this).parent().parent().parent().parent().data("uid");
                                var trigger = $(this).data("trigger");

                                if(trigger == "saveElementByUid") {
                                    var datas = Centauri.Helper.FieldsHelper($(".content-element.active"), ".fields");

                                    Centauri.fn.Ajax(
                                        "ContentElements",
                                        "saveElementByUid",

                                        {
                                            uid: uid,
                                            datas: JSON.stringify(datas)
                                        },

                                        {
                                            success: function(data) {
                                                data = JSON.parse(data);
                                                Centauri.Notify(data.type, data.title, data.description);
                                            },

                                            error: function(data) {
                                                console.error(data);
                                            }
                                        }
                                    );
                                }

                                if(trigger == "hideElementByUid") {
                                    $(this).toggleClass("btn-primary btn-info");
                                    $("i", $(this)).toggleClass("fa-eye fa-eye-slash");

                                    Centauri.fn.Ajax(
                                        "ContentElements",
                                        "hideElementByUid",

                                        {
                                            uid: uid
                                        },

                                        {
                                            success: function(data) {
                                                data = JSON.parse(data);
                                                Centauri.Notify(data.type, data.title, data.description);
                                            },

                                            error: function(data) {
                                                console.error(data);
                                            }
                                        }
                                    );
                                }

                                if(trigger == "deleteElementByUid") {
                                    Centauri.fn.Modal(
                                        Centauri.__trans.modals.areyousure,
                                        "Do you want to continue deleting this element?",
                
                                        {
                                            id: "areyousure_deleteelement",

                                            close: {
                                                label: Centauri.__trans.modals.btn_cancel,
                                                class: "warning"
                                            },
                
                                            save: {
                                                label: Centauri.__trans.modals.btn_delete,
                                                class: "danger"
                                            }
                                        },
                
                                        {
                                            save() {
                                                Centauri.fn.Ajax(
                                                    "ContentElements",
                                                    "deleteElementByUid",

                                                    {
                                                        uid: uid
                                                    },

                                                    {
                                                        success: function(data) {
                                                            data = JSON.parse(data);
                                                            Centauri.Notify(data.type, data.title, data.description);
                                                            Centauri.fn.Ajax.Overlayer = false;
                                                            Centauri.Helper.findByPidHelper(Centauri.Components.PagesComponent.uid);
                                                        },

                                                        error: function(data) {
                                                            console.error(data);
                                                        }
                                                    }
                                                );
                                            }
                                        }
                                    );
                                }
                            });

                            setTimeout(function() {
                                $(".fields", $contentelement).slideDown(function() {
                                    $this.toggleClass("btn-primary btn-info");
                                    Centauri.View.ContentElementsView($contentelement);
                                });
                            }, 100);
                        },

                        error: function(data) {
                            console.error(data);
                        }
                    }
                );
            } else {
                $fields = $contentelement.find(".fields");

                $fields.slideToggle(function() {
                    $this.toggleClass("btn-primary btn-info");
                });
            }
        });
    });
};
