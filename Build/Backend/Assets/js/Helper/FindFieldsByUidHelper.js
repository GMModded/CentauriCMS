Centauri.Helper.FindFieldsByUidHelper = ($contentelement, $editBtnElement) => {
    Centauri.fn.Ajax(
        "ContentElements",
        "findFieldsByUid",

        {
            uid: $contentelement.attr("data-uid")
        },

        {
            success: function(data) {
                if(Centauri.elExists($(".data", $contentelement))) {
                    $(".data", $contentelement).remove();
                }

                $(".top .button-view .edit i", $contentelement).removeClass("d-none");
                $(".top .button-view .edit .spinner-grow", $contentelement).remove();

                $(".overlayer").removeClass("hidden");

                $contentelement.data("loading-state", "loaded");
                $contentelement.append("<div class='data'></div>");
                $(".data", $contentelement).append(data);

                Centauri.View.ContentElementsView($contentelement);

                Centauri.Components.CreateNewInlineComponent();
                Centauri.Components.AccordionComponent();

                if($contentelement.data("ctype") == "grids") {
                    Centauri.Modal.NewContentElementModal();
                }

                $(".data > .fields select", $contentelement).materialSelect();

                /**
                 * Initializing CKEditor 5
                 */
                Centauri.Service.CKEditorInitService();

                /**
                 * Initializing ColorPickers
                 */
                $(".data .color-picker", $contentelement).each(function() {
                    let $_this = $(this);

                    new Pickr({
                        el: ".color-picker",
                        default: "rgba(0, 0, 0, 1)",

                        components: {
                            preview: true,
                            opacity: true,
                            hue: true,

                            interaction: {
                                hex: true,
                                rgba: true,
                                hsla: true,
                                input: true,
                                clear: true,
                                save: true
                            }
                        },

                        onSave: (hsva, instance) => {
                            $(instance._root.root).parent().find("> input").val(hsva.toRGBA().toString());
                        }
                    });
                });

                /**
                 * Sorting
                 */
                Centauri.Service.CESortingService();

                /**
                 * EditorListener
                 */
                Centauri.Listener.EditorListener()

                $(".row button", $contentelement).on("click", function() {
                    let $parent = $(this).parent().parent().parent().parent();

                    if($parent.hasClass("data")) {
                        $parent = $parent.parent();
                    }

                    var uid = $parent.data("uid");
                    var trigger = $(this).data("trigger");

                    

                    if(trigger == "saveElementByUid") {
                        let datas = Centauri.Helper.FieldsHelper($(".fields"), ".content-element.active");

                        let tempArr = [];
                        let tableInfo = {};
                        let i = 0;

                        Object.keys(datas).forEach((data) => {
                            tempArr.push(datas[data]);
                            tableInfo[i] = data;
                            i++;
                        });

                        let jsonDatas = JSON.stringify(tempArr);

                        Centauri.fn.Ajax(
                            "ContentElements",
                            "saveElementByUid",

                            {
                                uid: uid,
                                datas: jsonDatas,
                                tableInfo: tableInfo
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
                    $(".data > .fields", $contentelement).slideDown();
                    $editBtnElement.toggleClass("btn-primary btn-info");
                    Centauri.View.ContentElementsView($contentelement);

                    $(".top .button-view .edit i", $contentelement).removeClass("disabled");

                    Centauri.Helper.PagesHelper();
                }, 100);
            },

            error: function(data) {
                console.error(data);
            }
        }
    );
};
